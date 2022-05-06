<?php

namespace App\Controller;

use App\Form\WorldcupType;
use App\Repository\TeamRepository;
use App\Repository\WorldcupMatchRepository;
use App\Service\Worldcup\Matches\MExportContent;
use App\Service\Worldcup\Matches\MImportContent;
use App\Service\Worldcup\Results\RExportContent;
use App\Service\Worldcup\Teams\TImportContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportWorldcupDataController extends AbstractController
{
    #[Route('/', name: 'app_import_data_imports')]
    public function imports(
        Request $request, WorldcupMatchRepository $worldcupMatchRepository, TeamRepository $teamRepository,
        TImportContent $teamImportJsonContent, MImportContent $matchImportContent
        ): Response
    {

        $form = $this->createForm(WorldcupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $urlTeams = "http://worldcup.sfg.io/teams";
            $importTeams = $teamImportJsonContent->execute($urlTeams);

            $urlMatches = "http://worldcup.sfg.io/matches";
            $importMatches = $matchImportContent->execute($urlMatches);

            // return $this->redirectToRoute('app_export_data_teams_results');
        }

        $matchExists = $teamExists = 'not';
        if (!empty($worldcupMatchRepository->findAll())) {
            $matchExists = 'exists';
        }
        if (!empty($teamRepository->findAll())) {
            $teamExists = 'exists';
        }

        return $this->renderForm('worldcup_import/json_import.html.twig', [
            'form' => $form,
            'match_exists' => $matchExists,
            'team_exists' => $teamExists,
        ]);
    }

    #[Route('/worldcup/teams/results', name: 'app_export_data_teams_results')]
    public function results(RExportContent $resultExportContent): Response
    {
        $json = $resultExportContent->execute('teamId', 'ASC');

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route('/worldcup/matches', name: 'app_export_data_matches')]
    public function matches(MExportContent $exportJsonContent): Response
    {
        $json = $exportJsonContent->execute('weather_temp_celsius', 'DESC');

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

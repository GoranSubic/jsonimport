<?php

namespace App\Controller;

use App\Form\WorldcupType;
use App\Service\Todos\ExportServiceInterface;
use App\Service\Todos\ImportServiceInterface;
use App\Service\Worldcup\Matches\MExportContent;
use App\Service\Worldcup\Matches\MImportContent;
use App\Service\Worldcup\Results\RExportContent;
use App\Service\Worldcup\Teams\TImportContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportDataController extends AbstractController
{
    #[Route('/worldcup', name: 'app_import_data_imports')]
    public function imports(
        Request $request,
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

            return $this->redirectToRoute('app_export_data_teams_results');
        }

        return $this->renderForm('worldcup_import/json_import.html.twig', [
            'form' => $form,
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
        $json = $exportJsonContent->execute('weather_temp_celsius', 'ASC');

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route('/', name: 'app_import_data_todos')]
    public function todos(ImportServiceInterface $importJsonContent, ExportServiceInterface $exportJsonContent): Response
    {
        $url = "https://jsonplaceholder.typicode.com/todos";

        $messageArray = [];
        $importToDos = $importJsonContent->execute($url, $messageArray);

        $json = $exportJsonContent->execute('title', 'ASC');

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

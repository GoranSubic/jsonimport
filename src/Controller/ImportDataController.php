<?php

namespace App\Controller;

use App\Service\Todos\ExportServiceInterface;
use App\Service\Todos\ImportServiceInterface;
use App\Service\Worldcup\Matches\MExportContent;
use App\Service\Worldcup\Matches\MImportContent;
use App\Service\Worldcup\Results\RExportContent;
use App\Service\Worldcup\Results\RImportContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportDataController extends AbstractController
{
    #[Route('/worldcup/teams/results', name: 'app_import_data_results')]
    public function results(RImportContent $importJsonContent, RExportContent $exportJsonContent): Response
    {
        $url = "http://worldcup.sfg.io/teams/results";

        $importResults = $importJsonContent->execute($url);




        $json = $exportJsonContent->execute('title', 'ASC');

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route('/worldcup/matches', name: 'app_import_data_matches')]
    public function matches(MImportContent $importJsonContent, MExportContent $exportJsonContent): Response
    {
        $url = "http://worldcup.sfg.io/matches";

        $importMatches = $importJsonContent->execute($url);




        $json = $exportJsonContent->execute('title', 'ASC');

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

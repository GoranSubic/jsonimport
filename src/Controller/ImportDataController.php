<?php

namespace App\Controller;

use App\Service\ExportJsonContent;
use App\Service\ImportJsonContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportDataController extends AbstractController
{
    #[Route('/', name: 'app_import_data')]
    public function index(ImportJsonContent $importJsonContent, ExportJsonContent $exportJsonContent): Response
    {
        $url = "https://jsonplaceholder.typicode.com/todos";

        $messageArray = [];
        $importToDos = $importJsonContent->todosToDb($url, $messageArray);

        $json = $exportJsonContent->todosFromDb();

        $response = new Response();
        $response->setContent($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}

<?php

namespace App\Controller;

use App\Service\Todos\ExportServiceInterface;
use App\Service\Todos\ImportServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportDataController extends AbstractController
{
    #[Route('/', name: 'app_import_data')]
    public function index(ImportServiceInterface $importJsonContent, ExportServiceInterface $exportJsonContent): Response
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

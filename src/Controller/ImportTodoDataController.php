<?php

namespace App\Controller;

use App\Service\Todos\ExportServiceInterface;
use App\Service\Todos\ImportServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ImportTodoDataController extends AbstractController
{
    #[Route('/todos', name: 'app_import_data_todos')]
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

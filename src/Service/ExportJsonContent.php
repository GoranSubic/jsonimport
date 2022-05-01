<?php

namespace App\Service;

use App\Repository\ToDosRepository;
use Doctrine\ORM\EntityManagerInterface;

class ExportJsonContent implements ExportServiceInterface
{
  protected $entityManager;

  protected $toDosRepository;

  public function __construct(EntityManagerInterface $entityManager, ToDosRepository $toDosRepository)
  {
    $this->entityManager = $entityManager;
    $this->toDosRepository = $toDosRepository;
  }
  
  public function execute(string $orderBy, string $direction): string
  {
    $allToDos = $this->toDosRepository->findBy([], [$orderBy => $direction]);
    $json = json_encode($allToDos, JSON_PRETTY_PRINT);

    return $json;
  }
}
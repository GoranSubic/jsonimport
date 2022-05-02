<?php

namespace App\Service\Worldcup\Results;

use App\Repository\ToDosRepository;
use Doctrine\ORM\EntityManagerInterface;

class ResultsExportJsonContent
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
    // Todo export data
    // $allToDos = $this->toDosRepository->findBy([], [$orderBy => $direction]);
    $allMatches = [];
    $json = json_encode($allMatches, JSON_PRETTY_PRINT);

    return $json;
  }
}
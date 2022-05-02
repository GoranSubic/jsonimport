<?php

namespace App\Service\Worldcup\Teams;

use App\Repository\ToDosRepository;
use Doctrine\ORM\EntityManagerInterface;

class TeamsExportJsonContent
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
    $allTeams = [];
    $json = json_encode($allTeams, JSON_PRETTY_PRINT);

    return $json;
  }
}
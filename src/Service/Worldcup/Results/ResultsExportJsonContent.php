<?php

namespace App\Service\Worldcup\Results;

use App\Repository\TeamRepository;
use App\Repository\ToDosRepository;
use Doctrine\ORM\EntityManagerInterface;

class ResultsExportJsonContent
{
  protected $entityManager;

  protected $teamRepository;

  public function __construct(EntityManagerInterface $entityManager, TeamRepository $teamRepository)
  {
    $this->entityManager = $entityManager;
    $this->teamRepository = $teamRepository;
  }
  
  public function execute(string $orderBy, string $direction): string
  {
    // $allTeams = $this->teamRepository->findBy([], [$orderBy => $direction]);
    $allTeams = $this->teamRepository->findTeamResults();
    $json = json_encode($allTeams, JSON_PRETTY_PRINT);

    return $json;
  }
}
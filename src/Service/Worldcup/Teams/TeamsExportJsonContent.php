<?php

namespace App\Service\Worldcup\Teams;

use App\Service\Worldcup\WorldcupExportServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class TeamsExportJsonContent implements WorldcupExportServiceInterface
{
  protected $entityManager;

  protected $toDosRepository;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }
  
  public function execute(string $orderBy, string $direction): string
  {
    // Todo export data
    $allTeams = [];
    $json = json_encode($allTeams, JSON_PRETTY_PRINT);

    return $json;
  }
}
<?php

namespace App\Service\Worldcup\Matches;

use App\Repository\WorldcupMatchRepository;
use App\Service\Worldcup\WorldcupExportServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class MatchesExportJsonContent implements WorldcupExportServiceInterface
{
  protected $entityManager;

  protected $worldcupMatchRepository;

  public function __construct(EntityManagerInterface $entityManager, WorldcupMatchRepository $worldcupMatchRepository)
  {
    $this->entityManager = $entityManager;
    $this->worldcupMatchRepository = $worldcupMatchRepository;
  }
  
  public function execute(string $orderBy = 'id', string $direction = 'DESC'): string
  {
    if ($orderBy != 'weather_temp_celsius') {
      $allMatches = $this->worldcupMatchRepository->findBy([], [$orderBy => $direction]);
    } else {
      $allMatches = $this->worldcupMatchRepository->findAllMatchesByTemperature($direction);
    }
    $json = json_encode($allMatches, JSON_PRETTY_PRINT);

    return $json;
  }
}
<?php

namespace App\Service\Worldcup\Matches;

use App\Repository\ToDosRepository;
use App\Repository\WorldcupMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class MatchesExportJsonContent
{
  protected $entityManager;

  protected $worldcupMatchRepository;

  public function __construct(EntityManagerInterface $entityManager, WorldcupMatchRepository $worldcupMatchRepository)
  {
    $this->entityManager = $entityManager;
    $this->worldcupMatchRepository = $worldcupMatchRepository;
  }
  
  public function execute(string $orderBy = 'id', string $direction = 'ASC'): string
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
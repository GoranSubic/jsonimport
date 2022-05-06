<?php

namespace App\Service\Worldcup\Results;

use App\Repository\TeamRepository;
use App\Service\Worldcup\WorldcupExportServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class ResultsExportJsonContent implements WorldcupExportServiceInterface
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

    $wins = $this->teamRepository->findWinsResults();
    $draws = $this->teamRepository->findDrawsResults();
    $awayDraws = $this->teamRepository->findAwayDrawsResults();
    
    $goalsAgainstHome = $this->teamRepository->findHomeGoalsResults();
    $goalsAgainstAway = $this->teamRepository->findAwayGoalsResults();

    for ($i = 0; $i < count($allTeams); $i++) {
      $allTeams[$i]['wins'] = $wins[$i]['wins'];
      $allTeams[$i]['draws'] = $draws[$i]['draws'] + $awayDraws[$i]['away_draws'];
      $allTeams[$i]['losses'] = $allTeams[$i]['games_played'] - $allTeams[$i]['wins'] - $allTeams[$i]['draws'];
      
      $allTeams[$i]['points'] = ($allTeams[$i]['wins'] * 3) + $allTeams[$i]['draws'];

      $goals = $goalsAgainstHome[$i]['goals_for'] + $goalsAgainstAway[$i]['goals_for'];
      $allTeams[$i]['goals_for'] = $goals;

      $goalsAgainst = $goalsAgainstHome[$i]['goals_against'] + $goalsAgainstAway[$i]['goals_against'];
      $allTeams[$i]['goals_against'] = $goalsAgainst;

      $allTeams[$i]['goal_differential'] = $goals - $goalsAgainst;
    }

    $json = json_encode($allTeams, JSON_PRETTY_PRINT);

    return $json;
  }
}
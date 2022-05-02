<?php

namespace App\Service\Worldcup\Matches;

use App\Entity\TeamEvent;
use App\Entity\TeamResult;
use App\Entity\Weather;
use App\Entity\WorldcupMatch;
use App\Repository\TeamEventRepository;
use App\Repository\WorldcupMatchRepository;
use Doctrine\ORM\EntityManagerInterface;

class MatchesImportJsonContent
{
  protected $entityManager;

  protected $worldcupMatchRepository;

  protected $teamEventRepository;

  public function __construct(EntityManagerInterface $entityManager, WorldcupMatchRepository $worldcupMatchRepository, TeamEventRepository $teamEventRepository)
  {
    $this->entityManager = $entityManager;
    $this->worldcupMatchRepository = $worldcupMatchRepository;
    $this->teamEventRepository = $teamEventRepository;
  }

  public function execute(string $url): bool
  {
    $json = [];

    if (!empty($url)) {
      $json = file_get_contents($url);

      $this->savesToDbDoctrine($json);
      return TRUE;
    }

    return FALSE;
  }

  public function savesToDbDoctrine(string $json)
  {
    $json = json_decode($json, TRUE);
        
    foreach ($json as $getData) {
      $match = !empty($getData['fifa_id']) ? $getData['fifa_id'] : '';

      // Select query - check if existing worldcup_match.
      $sqlSelect = "SELECT id, venue FROM worldcup_match WHERE fifa_id LIKE :fifa_id";
      $stmtSelect = $this->entityManager->getConnection()->prepare($sqlSelect);
      $s = $stmtSelect->execute(['fifa_id' => $match])->fetchAssociative();

      // Insert/update query.
      if (!empty($s) && !empty($s['id'])) {
        $messageArray['existing_match'][] = $s['venue'];
        $wcMatch = $this->worldcupMatchRepository->find($s['id']);
      } else {
        $wcMatch = new WorldcupMatch();
        $this->entityManager->persist($wcMatch);
      }

      $wcMatch->setVenue($getData['venue']);
      $wcMatch->setLocation($getData['location']);
      $wcMatch->setStatus($getData['status']);
      $wcMatch->setTime($getData['time']);
      $wcMatch->setFifaId($getData['fifa_id']);

      $weatherArr = $getData['weather'];
      $weather = new Weather(
        $weatherArr['humidity'], 
        $weatherArr['temp_celsius'], 
        $weatherArr['temp_farenheit'],
        $weatherArr['wind_speed'],
        $weatherArr['description']);
      $wcMatch->setWeather($weather);

      $wcMatch->setAttendance($getData['attendance']);
      $wcMatch->setOfficials($getData['officials']);
      $wcMatch->setStageName($getData['stage_name']);
      $wcMatch->setHomeTeamCountry($getData['home_team_country']);
      $wcMatch->setAwayTeamCountry($getData['away_team_country']);
      $wcMatch->setDatetime(new \DateTime($getData['datetime']));
      $wcMatch->setWinner($getData['winner']);
      $wcMatch->setWinnerCode($getData['winner_code']);

      $homeTeamArr = $getData['home_team'];
      $homeTeam = new TeamResult($homeTeamArr['country'], $homeTeamArr['code'], $homeTeamArr['goals'], $homeTeamArr['penalties']);
      $wcMatch->setHomeTeam($homeTeam);

      $awayTeamArr = $getData['away_team'];
      $awayTeam = new TeamResult($awayTeamArr['country'], $awayTeamArr['code'], $awayTeamArr['goals'], $awayTeamArr['penalties']);
      $wcMatch->setAwayTeam($awayTeam);

      $homeTeamEventsArr = $getData['home_team_events'];
      foreach ($homeTeamEventsArr as $homeTeamEvent) {
        $teamEvent = $this->teamEventRepository->findOneBy(['eventId' => $homeTeamEvent['id']]);

        if (empty($teamEvent)) {
          $teamEvent = new TeamEvent($homeTeamEvent['id'], $homeTeamEvent['type_of_event'], $homeTeamEvent['player'], $homeTeamEvent['time'], $wcMatch, NULL);
          $this->entityManager->persist($teamEvent);
          $this->entityManager->flush();
        }

        $wcMatchTeamEvents = $wcMatch->getHomeTeamEvents();
        if (!$wcMatchTeamEvents->contains($teamEvent)) {
          $wcMatch->addHomeTeamEvent($teamEvent);
        }
      }

      $awayTeamEventsArr = $getData['away_team_events'];
      foreach ($awayTeamEventsArr as $awayTeamEvent) {
        $teamEvent = $this->teamEventRepository->findOneBy(['eventId' => $awayTeamEvent['id']]);

        if (empty($teamEvent)) {
          $teamEvent = new TeamEvent($awayTeamEvent['id'], $awayTeamEvent['type_of_event'], $awayTeamEvent['player'], $awayTeamEvent['time'], NULL, $wcMatch);
          $this->entityManager->persist($teamEvent);
          $this->entityManager->flush();
        }

        $wcMatchTeamEvents = $wcMatch->getAwayTeamEvents();
        if (!$wcMatchTeamEvents->contains($teamEvent)) {
          $wcMatch->addAwayTeamEvent($teamEvent);
        }
      }

      $wcMatch->setHomeTeamStatistics($getData['home_team_statistics']);
      $wcMatch->setAwayTeamStatistics($getData['away_team_statistics']);
      $wcMatch->setLastEventUpdateAt(new \DateTime($getData['last_event_update_at']));
      $wcMatch->setLastScoreUpdateAt(new \DateTime($getData['last_score_update_at']));
      
      $this->entityManager->persist($wcMatch);
      $this->entityManager->flush();
    }

    $this->entityManager->flush();
    $this->entityManager->clear();
  }

  public function savesToDb(string $json)
  {
    $json = json_decode($json, TRUE);

    foreach ($json as $getData) {
      $match = !empty($getData['fifa_id']) ? $getData['fifa_id'] : '';

      // Select query - check if existing team.
      $sqlSelect = "SELECT id, venue FROM worldcup_match WHERE fifa_id LIKE :fifa_id";
      $stmtSelect = $this->entityManager->getConnection()->prepare($sqlSelect);
      $s = $stmtSelect->execute(['fifa_id' => $match])->fetchAssociative();

      // Insert/update query.
      $queryFor = '';
      if (!empty($s) && !empty($s['id'])) {
        $queryFor = 'update';
        $messageArray['existing_match'][] = $s['venue'];

        $sql = "UPDATE worldcup_match SET 
          venue=:venue, 
          location=:location, 
          status=:status,
          time=:time,
          fifa_id=:fifa_id,
          attendance=:attendance,
          stage_name=:stage_name,
          home_team_country=:home_team_country,
          away_team_country=:away_team_country,
          datetime=:datetime,
          winner=:winner,
          winner_code=:winner_code
        ";
        $sql .= " WHERE (id = :iid)";
      } else {
        $queryFor = 'insert';

        $sql = "INSERT INTO worldcup_match (venue, location, status, time, fifa_id, attendance, 
          stage_name, home_team_country, away_team_country, datetime, winner, winner_code) 
          VALUES (:venue, :location, :status, :time, :fifa_id, :attendance, 
          :stage_name, :home_team_country, :away_team_country, :datetime, :winner, :winner_code)";
      }

      $stmt = $this->entityManager->getConnection()->prepare($sql);
      $params = [
        'venue' => !empty($getData['venue']) ? $getData['venue'] : '',
        'location' => !empty($getData['location']) ? $getData['location'] : ' UPDATED empty location ',
        'status' => !empty($getData['status']) ? $getData['status'] : NULL,
        'time' => !empty($getData['time']) ? $getData['time'] : NULL,
        'fifa_id' => !empty($getData['fifa_id']) ? $getData['fifa_id'] : NULL,
        'attendance' => !empty($getData['attendance']) ? $getData['attendance'] : NULL,

        
        'stage_name' => !empty($getData['stage_name']) ? $getData['stage_name'] : NULL,
        'home_team_country' => !empty($getData['home_team_country']) ? $getData['home_team_country'] : NULL,
        'away_team_country' => !empty($getData['away_team_country']) ? $getData['away_team_country'] : NULL,
        'datetime' => !empty($getData['datetime']) ? date("Y-m-d H:i:s", strtotime($getData['datetime'])) : NULL,
        'winner' => !empty($getData['winner']) ? $getData['winner'] : NULL,
        'winner_code' => !empty($getData['winner_code']) ? $getData['winner_code'] : NULL,

      ];
      if ($queryFor === 'update') $params['iid'] = !empty($s) && !empty($s['id']) ? $s['id'] : NULL;
      $r = $stmt->execute($params);

      if (!$r) $messageArray['skipped_todo'][] = $match;
    }
  }
}
<?php

namespace App\Entity;

use App\Repository\WorldcupMatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: WorldcupMatchRepository::class)]
class WorldcupMatch implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $venue;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $location;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $status;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $time;

    #[ORM\Column(type: 'integer')]
    private $fifaId;

    #[ORM\Embedded(class: Weather::class, columnPrefix: 'weather_')]
    private $weather;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $attendance;

    #[ORM\Column(type: 'array', nullable: true)]
    private $officials = [];

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $stageName;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $homeTeamCountry;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $awayTeamCountry;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $datetime;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $winner;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $winnerCode;

    #[ORM\Embedded(class: TeamResult::class, columnPrefix: 'team_result_home_')]
    private $homeTeam;

    #[ORM\Embedded(class: TeamResult::class, columnPrefix: 'team_result_away_')]
    private $awayTeam;

    #[ORM\OneToMany(mappedBy: 'worldcupMatch', targetEntity: TeamEvent::class)]
    private $homeTeamEvents;

    #[ORM\OneToMany(mappedBy: 'worldcupMatchAway', targetEntity: TeamEvent::class)]
    private $awayTeamEvents;

    #[ORM\Column(type: 'array', nullable: true)]
    private $homeTeamStatistics = [];

    #[ORM\Column(type: 'array', nullable: true)]
    private $awayTeamStatistics = [];

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $lastEventUpdateAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private $lastScoreUpdateAt;

    public function __construct()
    {
        $this->homeTeamEvents = new ArrayCollection();
        $this->awayTeamEvents = new ArrayCollection();
    }

    public function jsonSerialize(): array
    {
        return [
            'venue' => $this->getVenue(),
            'location' => $this->getLocation(),
            'status' => $this->getStatus(),
            'time' => $this->getTime(),
            'fifa_id' => $this->getFifaId(),
            'weather' => $this->getWeather(),
            'attendance' => $this->getAttendance(),
            'officials' => $this->getOfficials(),
            'stage_name' => $this->getStageName(),
            'home_team_country' => $this->getHomeTeamCountry(),
            'away_team_country' => $this->getAwayTeamCountry(),
            'datetime' => !empty($this->getDatetime()) ? $this->getDatetime()->format('Y-m-d\TH:i:s\Z') : NULL,
            'winner' => $this->getWinner(),
            'winner_code' => $this->getWinnerCode(),
            'home_team' => $this->getHomeTeam(),
            'away_team' => $this->getAwayTeam(),
            'home_team_events' => $this->getHomeTeamEvents()->toArray(),
            'away_team_events' => $this->getAwayTeamEvents()->toArray(),
            'home_team_statistics' => $this->getHomeTeamStatistics(),
            'away_team_statistics' => $this->getAwayTeamStatistics(),
            'last_event_update_at' => !empty($this->getLastEventUpdateAt()) ? $this->getLastEventUpdateAt()->format('Y-m-d\TH:i:s\Z') : NULL,
            'last_score_update_at' => !empty($this->getlastScoreUpdateAt()) ? $this->getlastScoreUpdateAt()->format('Y-m-d\TH:i:s\Z') : NULL,
        ];
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVenue(): ?string
    {
        return $this->venue;
    }

    public function setVenue(?string $venue): self
    {
        $this->venue = $venue;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(?string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getFifaId(): ?int
    {
        return $this->fifaId;
    }

    public function setFifaId(int $fifaId): self
    {
        $this->fifaId = $fifaId;

        return $this;
    }

    public function getWeather()
    {
        return $this->weather;
    }

    public function setWeather($weather): self
    {
        $this->weather = $weather;

        return $this;
    }

    public function getAttendance(): ?int
    {
        return $this->attendance;
    }

    public function setAttendance(?int $attendance): self
    {
        $this->attendance = $attendance;

        return $this;
    }

    public function getOfficials(): ?array
    {
        return $this->officials;
    }

    public function setOfficials(?array $officials): self
    {
        $this->officials = $officials;

        return $this;
    }

    public function getStageName(): ?string
    {
        return $this->stageName;
    }

    public function setStageName(?string $stageName): self
    {
        $this->stageName = $stageName;

        return $this;
    }

    public function getHomeTeamCountry(): ?string
    {
        return $this->homeTeamCountry;
    }

    public function setHomeTeamCountry(?string $homeTeamCountry): self
    {
        $this->homeTeamCountry = $homeTeamCountry;

        return $this;
    }

    public function getAwayTeamCountry(): ?string
    {
        return $this->awayTeamCountry;
    }

    public function setAwayTeamCountry(?string $awayTeamCountry): self
    {
        $this->awayTeamCountry = $awayTeamCountry;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(?\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getWinner(): ?string
    {
        return $this->winner;
    }

    public function setWinner(?string $winner): self
    {
        $this->winner = $winner;

        return $this;
    }

    public function getWinnerCode(): ?string
    {
        return $this->winnerCode;
    }

    public function setWinnerCode(?string $winnerCode): self
    {
        $this->winnerCode = $winnerCode;

        return $this;
    }

    public function getHomeTeam()
    {
        return $this->homeTeam;
    }

    public function setHomeTeam($homeTeam): self
    {
        $this->homeTeam = $homeTeam;

        return $this;
    }

    public function getAwayTeam()
    {
        return $this->awayTeam;
    }

    public function setAwayTeam($awayTeam): self
    {
        $this->awayTeam = $awayTeam;

        return $this;
    }

    /**
     * @return Collection<int, TeamEvent>
     */
    public function getHomeTeamEvents(): Collection
    {
        return $this->homeTeamEvents;
    }

    public function addHomeTeamEvent(TeamEvent $homeTeamEvent): self
    {
        if (!$this->homeTeamEvents->contains($homeTeamEvent)) {
            $this->homeTeamEvents[] = $homeTeamEvent;
            $homeTeamEvent->setWorldcupMatch($this);
        }

        return $this;
    }

    public function removeHomeTeamEvent(TeamEvent $homeTeamEvent): self
    {
        if ($this->homeTeamEvents->removeElement($homeTeamEvent)) {
            // set the owning side to null (unless already changed)
            if ($homeTeamEvent->getWorldcupMatch() === $this) {
                $homeTeamEvent->setWorldcupMatch(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamEvent>
     */
    public function getAwayTeamEvents(): Collection
    {
        return $this->awayTeamEvents;
    }

    public function addAwayTeamEvent(TeamEvent $awayTeamEvent): self
    {
        if (!$this->awayTeamEvents->contains($awayTeamEvent)) {
            $this->awayTeamEvents[] = $awayTeamEvent;
            $awayTeamEvent->setWorldcupMatchAway($this);
        }

        return $this;
    }

    public function removeAwayTeamEvent(TeamEvent $awayTeamEvent): self
    {
        if ($this->awayTeamEvents->removeElement($awayTeamEvent)) {
            // set the owning side to null (unless already changed)
            if ($awayTeamEvent->getWorldcupMatchAway() === $this) {
                $awayTeamEvent->setWorldcupMatchAway(null);
            }
        }

        return $this;
    }

    public function getHomeTeamStatistics(): ?array
    {
        return $this->homeTeamStatistics;
    }

    public function setHomeTeamStatistics(?array $homeTeamStatistics): self
    {
        $this->homeTeamStatistics = $homeTeamStatistics;

        return $this;
    }

    public function getAwayTeamStatistics(): ?array
    {
        return $this->awayTeamStatistics;
    }

    public function setAwayTeamStatistics(?array $awayTeamStatistics): self
    {
        $this->awayTeamStatistics = $awayTeamStatistics;

        return $this;
    }

    public function getLastEventUpdateAt(): ?\DateTimeInterface
    {
        return $this->lastEventUpdateAt;
    }

    public function setLastEventUpdateAt(?\DateTimeInterface $lastEventUpdateAt): self
    {
        $this->lastEventUpdateAt = $lastEventUpdateAt;

        return $this;
    }

    public function getLastScoreUpdateAt(): ?\DateTimeInterface
    {
        return $this->lastScoreUpdateAt;
    }

    public function setLastScoreUpdateAt(?\DateTimeInterface $lastScoreUpdateAt): self
    {
        $this->lastScoreUpdateAt = $lastScoreUpdateAt;

        return $this;
    }
}

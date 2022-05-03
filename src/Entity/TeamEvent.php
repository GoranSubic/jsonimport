<?php

namespace App\Entity;

use App\Repository\TeamEventRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: TeamEventRepository::class)]
class TeamEvent implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', unique: true)]
    private $eventId;

    #[ORM\Column(type: 'string', length: 255)]
    private $typeOfEvent;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $player;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $time;

    #[ORM\ManyToOne(targetEntity: WorldcupMatch::class, inversedBy: 'homeTeamEvents')]
    private $worldcupMatch;

    #[ORM\ManyToOne(targetEntity: WorldcupMatch::class, inversedBy: 'awayTeamEvents')]
    private $worldcupMatchAway;

    public function __construct(int $eventId, string $typeOfEvent, string $player, string $time, $worldcupMatch = NULL, $worldcupMatchAway = NULL)
    {
        $this->eventId = $eventId;
        $this->typeOfEvent = $typeOfEvent;
        $this->player = $player;
        $this->time = $time;
        $this->worldcupMatch = $worldcupMatch;
        $this->worldcupMatchAway = $worldcupMatchAway;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): ?int
    {
        return $this->eventId;
    }

    public function setEventId(int $eventId): self
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getTypeOfEvent(): ?string
    {
        return $this->typeOfEvent;
    }

    public function setTypeOfEvent(string $typeOfEvent): self
    {
        $this->typeOfEvent = $typeOfEvent;

        return $this;
    }

    public function getPlayer(): ?string
    {
        return $this->player;
    }

    public function setPlayer(?string $player): self
    {
        $this->player = $player;

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

    public function getWorldcupMatch(): ?WorldcupMatch
    {
        return $this->worldcupMatch;
    }

    public function setWorldcupMatch(?WorldcupMatch $worldcupMatch): self
    {
        $this->worldcupMatch = $worldcupMatch;

        return $this;
    }

    public function getWorldcupMatchAway(): ?WorldcupMatch
    {
        return $this->worldcupMatchAway;
    }

    public function setWorldcupMatchAway(?WorldcupMatch $worldcupMatchAway): self
    {
        $this->worldcupMatchAway = $worldcupMatchAway;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getEventId(),
            'type_of_event' => $this->getTypeOfEvent(),
            'player' => $this->getPlayer(),
            'time' => $this->getTime(),
        ];
    }
}

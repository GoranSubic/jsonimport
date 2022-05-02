<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team implements JsonSerializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer', unique: true)]
    private $teamId;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $country;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $alternateName;

    #[ORM\Column(type: 'string', length: 255)]
    private $fifaCode;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $groupId;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $groupLetter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamId(): ?int
    {
        return $this->teamId;
    }

    public function setTeamId(int $teamId): self
    {
        $this->teamId = $teamId;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getAlternateName(): ?string
    {
        return $this->alternateName;
    }

    public function setAlternateName(?string $alternateName): self
    {
        $this->alternateName = $alternateName;

        return $this;
    }

    public function getFifaCode(): ?string
    {
        return $this->fifaCode;
    }

    public function setFifaCode(string $fifaCode): self
    {
        $this->fifaCode = $fifaCode;

        return $this;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function setGroupId(?int $groupId): self
    {
        $this->groupId = $groupId;

        return $this;
    }

    public function getGroupLetter(): ?string
    {
        return $this->groupLetter;
    }

    public function setGroupLetter(?string $groupLetter): self
    {
        $this->groupLetter = $groupLetter;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getTeamId(),
            'country' => $this->getCountry(),
            'alternate_name' => $this->getAlternateName(),
            'fifa_code' => $this->getFifaCode(),
            'group_id' => $this->getGroupId(),
            'group_letter' => $this->getGroupLetter(),
        ];
    }
}

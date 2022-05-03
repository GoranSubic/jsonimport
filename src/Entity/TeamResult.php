<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Embeddable]
class TeamResult implements JsonSerializable
{
  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private $country;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private $code;

  #[ORM\Column(type: 'integer', nullable: true)]
  private $goals;

  #[ORM\Column(type: 'integer', nullable: true)]
  private $penalties;

  public function __construct(string $country, string $code, int $goals, int $penalties)
  {
    $this->country = $country;
    $this->code = $code;
    $this->goals = $goals;
    $this->penalties = $penalties;
  }

  public function getCountry(): ?string
  {
      return $this->country;
  }

  public function getCode(): ?string
  {
      return $this->code;
  }

  public function getGoals(): ?int
  {
      return $this->goals;
  }

  public function getPenalties(): ?int
  {
      return $this->penalties;
  }

  public function jsonSerialize(): array
  {
      return [
          'country' => $this->getCountry(),
          'code' => $this->getCode(),
          'goals' => $this->getGoals(),
          'penalties' => $this->getPenalties(),
      ];
  }
}

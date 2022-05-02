<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class TeamResult
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
}

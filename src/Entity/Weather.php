<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
class Weather
{
  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private $humidity;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private $tempCelsius;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private $tempFarenheit;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private $windSpeed;

  #[ORM\Column(type: 'string', length: 255, nullable: true)]
  private $description;

  public function __construct(string $humidity, string $tempCelsius, string $tempFarenheit, string $windSpeed, string $description)
  {
    $this->humidity = $humidity;
    $this->tempCelsius = $tempCelsius;
    $this->tempFarenheit = $tempFarenheit;
    $this->windSpeed = $windSpeed;
    $this->description = $description;   
  }
}
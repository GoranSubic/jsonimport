<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;

#[ORM\Embeddable]
class Weather implements JsonSerializable
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

  public function getHumidity(): ?string
  {
      return $this->humidity;
  }

  public function getTempCelsius(): ?string
  {
      return $this->tempCelsius;
  }

  public function getTempFarenheit(): ?string
  {
      return $this->tempFarenheit;
  }

  public function getWindSpeed(): ?string
  {
      return $this->windSpeed;
  }

  public function getDescription(): ?string
  {
      return $this->description;
  }

  public function jsonSerialize(): array
  {
      return [
          'humidity' => $this->getHumidity(),
          'temp_celsius' => $this->getTempCelsius(),
          'temp_farenheit' => $this->getTempFarenheit(),
          'wind_speed' => $this->getWindSpeed(),
          'description' => $this->getDescription(),
      ];
  }
}
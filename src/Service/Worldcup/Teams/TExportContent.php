<?php

namespace App\Service\Worldcup\Teams;

use App\Service\Worldcup\WorldcupExportServiceInterface;

class TExportContent implements WorldcupExportServiceInterface
{
  protected $exporter;

  public function __construct(TeamsExportJsonContent $teamsExportJsonContent)
  {
    $this->exporter = $teamsExportJsonContent;
  }
  
  public function execute(string $orderBy, string $direction): string
  {
    $json = $this->exporter->execute($orderBy, $direction);

    return $json;
  }
}
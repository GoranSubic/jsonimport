<?php

namespace App\Service\Worldcup\Matches;

use App\Service\Worldcup\WorldcupExportServiceInterface;

class MExportContent implements WorldcupExportServiceInterface
{
  protected $exporter;

  public function __construct(MatchesExportJsonContent $matchesExportJsonContent)
  {
    $this->exporter = $matchesExportJsonContent;
  }
  
  public function execute(string $orderBy, string $direction): string
  {
    $json = $this->exporter->execute($orderBy, $direction);

    return $json;
  }
}
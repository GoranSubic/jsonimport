<?php

namespace App\Service\Worldcup\Results;

use App\Service\Worldcup\WorldcupExportServiceInterface;

class RExportContent implements WorldcupExportServiceInterface
{
  protected $exporter;

  public function __construct(ResultsExportJsonContent $resultsExportJsonContent)
  {
    $this->exporter = $resultsExportJsonContent;
  }
  
  public function execute(string $orderBy, string $direction): string
  {
    $json = $this->exporter->execute($orderBy, $direction);

    return $json;
  }
}
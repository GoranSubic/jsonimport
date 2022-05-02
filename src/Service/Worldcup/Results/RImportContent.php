<?php

namespace App\Service\Worldcup\Results;

use App\Service\Worldcup\WorldcupImportServiceInterface;

class RImportContent implements WorldcupImportServiceInterface
{
  protected $importer;

  public function __construct(ResultsImportJsonContent $resultsImportJsonContent)
  {
    $this->importer = $resultsImportJsonContent;
  }

  public function execute(string $url): bool
  {
    $succees = $this->importer->execute($url);

    return $succees;
  }
}

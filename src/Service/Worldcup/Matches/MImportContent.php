<?php

namespace App\Service\Worldcup\Matches;

use App\Service\Worldcup\WorldcupImportServiceInterface;

class MImportContent implements WorldcupImportServiceInterface
{
  protected $importer;

  public function __construct(MatchesImportJsonContent $matchesImportJsonContent)
  {
    $this->importer = $matchesImportJsonContent;
  }

  public function execute(string $url): bool
  {
    $succees = $this->importer->execute($url);

    return $succees;
  }
}

<?php

namespace App\Service\Worldcup\Teams;

use App\Service\Worldcup\WorldcupImportServiceInterface;

class TImportContent implements WorldcupImportServiceInterface
{
  protected $importer;

  public function __construct(TeamsImportJsonContent $teamsImportJsonContent)
  {
    $this->importer = $teamsImportJsonContent;
  }

  public function execute(string $url): bool
  {
    $succees = $this->importer->execute($url);

    return $succees;
  }
}

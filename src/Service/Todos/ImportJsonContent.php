<?php

namespace App\Service\Todos;

use App\Service\Todos\ToDosImportJsonContent;

class ImportJsonContent implements ImportServiceInterface
{
  protected $importer;

  public function __construct(ToDosImportJsonContent $toDosImportJsonContent)
  {
    $this->importer = $toDosImportJsonContent;
  }

  public function execute(string $url, array &$messages): bool
  {
    $succees = $this->importer->execute($url, $messages);

    return $succees;
  }
}

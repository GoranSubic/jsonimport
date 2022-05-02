<?php

namespace App\Service\Todos;

class ExportJsonContent implements ExportServiceInterface
{
  protected $exporter;

  public function __construct(ToDosExportJsonContent $toDosExportJsonContent)
  {
    $this->exporter = $toDosExportJsonContent;
  }
  
  public function execute(string $orderBy, string $direction): string
  {
    $json = $this->exporter->execute($orderBy, $direction);

    return $json;
  }
}
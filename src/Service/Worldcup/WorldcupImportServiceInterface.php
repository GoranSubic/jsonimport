<?php

namespace App\Service\Worldcup;

interface WorldcupImportServiceInterface
{
  /**
   * @param string $url
   * 
   * @return bool
   */
  public function execute(string $url): bool;
}
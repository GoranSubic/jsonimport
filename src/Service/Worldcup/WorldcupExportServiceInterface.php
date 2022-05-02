<?php

namespace App\Service\Worldcup;

interface WorldcupExportServiceInterface
{
  /**
   * @param string $orderBy 
   * @param string $direction
   * 
   * @return bool
   */
  public function execute(string $orderBy, string $direction): string;
}
<?php

namespace App\Service;

interface ExportServiceInterface
{
    /**
     * @param string $orderBy 
     * @param string $direction
     * 
     * @return bool
     */
    public function execute(string $orderBy, string $direction): string;
}
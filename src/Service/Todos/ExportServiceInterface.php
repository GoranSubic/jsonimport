<?php

namespace App\Service\Todos;

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
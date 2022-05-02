<?php

namespace App\Service\Todos;

interface ImportServiceInterface
{
    /**
     * @param string $url
     * @param array $messages
     * 
     * @return bool
     */
    public function execute(string $url, array &$messages): bool;
}
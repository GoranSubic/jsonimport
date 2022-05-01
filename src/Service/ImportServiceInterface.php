<?php

namespace App\Service;

interface ImportServiceInterface
{
    /**
     * @param string $url
     * @param array $messages
     * 
     * @return bool
     */
    public function execute(string $url, array $messages): bool;

    /**
     * @param string $json
     * 
     * @return array
     */
    public function savesToDb(string $json): array;
}
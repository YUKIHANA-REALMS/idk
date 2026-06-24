<?php

namespace App\Core\DTO\Pterodactyl;

class Credentials
{
    public function __construct(
        private readonly string $url,
        private readonly string $apiKey,
    ) {
    }

    public function getUrl(): string
    {
        return rtrim($this->url, '/');
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }
}

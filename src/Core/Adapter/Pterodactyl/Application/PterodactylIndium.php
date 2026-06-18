<?php

namespace App\Core\Adapter\Pterodactyl\Application;

use App\Core\Contract\Pterodactyl\Application\PterodactylIndiumInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PterodactylIndium extends AbstractPterodactylApplicationAdapter implements PterodactylIndiumInterface
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getVersion(): array
    {
        $response = $this->makeRequest('GET', 'indium/version');
        return $this->validateServerResponse($response, 200);
    }
}

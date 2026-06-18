<?php

namespace App\Core\Contract\Pterodactyl\Application;

interface PterodactylIndiumInterface
{
    /**
     * Get Indium Panel Plugin version
     *
     * @return array
     */
    public function getVersion(): array;
}

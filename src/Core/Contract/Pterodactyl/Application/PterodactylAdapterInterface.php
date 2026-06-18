<?php

namespace App\Core\Contract\Pterodactyl\Application;

use App\Core\DTO\Pterodactyl\Credentials;

interface PterodactylAdapterInterface
{
    /**
     * Get servers management interface
     *
     * @return PterodactylServersInterface
     */
    public function servers(): PterodactylServersInterface;

    /**
     * Get users management interface
     *
     * @return PterodactylUsersInterface
     */
    public function users(): PterodactylUsersInterface;

    /**
     * Get nodes management interface
     *
     * @return PterodactylNodesInterface
     */
    public function nodes(): PterodactylNodesInterface;

    /**
     * Get node allocations management interface
     *
     * @return PterodactylNodeAllocationsInterface
     */
    public function nodeAllocations(): PterodactylNodeAllocationsInterface;

    /**
     * Get locations management interface
     *
     * @return PterodactylLocationsInterface
     */
    public function locations(): PterodactylLocationsInterface;

    /**
     * Get nests management interface
     *
     * @return PterodactylNestsInterface
     */
    public function nests(): PterodactylNestsInterface;

    /**
     * Get nest eggs management interface
     *
     * @return PterodactylNestEggsInterface
     */
    public function nestEggs(): PterodactylNestEggsInterface;

    /**
     * Get Indium Panel Plugin management interface
     *
     * @return PterodactylIndiumInterface
     */
    public function indium(): PterodactylIndiumInterface;

    public function setCredentials(Credentials $credentials): void;
}

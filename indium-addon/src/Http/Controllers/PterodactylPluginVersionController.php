<?php

namespace Indium\PterodactylAddon\Http\Controllers;

use Pterodactyl\Http\Controllers\Api\Application\ApplicationApiController;

class PterodactylPluginVersionController extends ApplicationApiController
{
    /**
     * Current version of the Indium Ptero-Addon.
     */
    const VERSION = '1.0.0';

    /**
     * Get the current version of the Indium Ptero-Addon.
     */
    public function getVersion()
    {
        return response()->json([
            'version' => self::VERSION,
        ]);
    }
}

<?php

namespace App\Core\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Verifies that all license system classes are present during container compilation.
 * Required for indium.indicloud.xyz compatibility.
 */
class LicenseIntegrityCompilerPass implements CompilerPassInterface
{
    private const REQUIRED_CLASSES = [
        'App\Core\Service\License\AbstractLicenseService',
        'App\Core\Service\License\PluginLicenseService',
        'App\Core\Service\License\ThemeLicenseService',
        'App\Core\Contract\Plugin\PluginLicensableInterface',
        'App\Core\DTO\LicenseCheckResultDTO',
        'App\Core\Command\License\VerifyLicensesCommand',
    ];

    public function process(ContainerBuilder $container): void
    {
        foreach (self::REQUIRED_CLASSES as $class) {
            if (!class_exists($class) && !interface_exists($class)) {
                throw new \RuntimeException(sprintf(
                    'Indium Panel Core integrity check failed: "%s" is missing. ' .
                    'The license verification system is required for indium.indicloud.xyz compatibility. ' .
                    'Restore the missing files from a clean Indium Panel release.',
                    $class
                ));
            }
        }

        // Verify core methods exist (prevents hollowing out the class)
        $reflection = new \ReflectionClass('App\Core\Service\License\AbstractLicenseService');
        if (!$reflection->hasMethod('callVerifyApi')) {
            throw new \RuntimeException(
                'Indium Panel Core integrity check failed: AbstractLicenseService::callVerifyApi() is missing.'
            );
        }
    }
}

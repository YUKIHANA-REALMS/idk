<?php

namespace App\Core\Service\Theme;

use App\Core\DTO\TemplateManifestDTO;
use App\Core\DTO\ThemeUploadWarningDTO;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class ThemeStructureValidator
{
    public function findThemeRoot(string $tempDir): ?string
    {
        // 1. Try standard structure: themes/{name}/template.json
        $themesDir = $tempDir . '/themes';
        if (is_dir($themesDir)) {
            $dirs = glob($themesDir . '/*', GLOB_ONLYDIR);
            foreach ($dirs as $dir) {
                if (file_exists($dir . '/template.json')) {
                    return $dir;
                }
            }
        }

        // 2. Try flat structure: template.json at root level
        if (file_exists($tempDir . '/template.json')) {
            // Create the expected themes/{name}/ structure
            $manifest = json_decode(file_get_contents($tempDir . '/template.json'), true);
            if (isset($manifest['template']['name'])) {
                $themeName = $manifest['template']['name'];
                $expectedDir = "$tempDir/themes/$themeName";
                if (!is_dir($expectedDir)) {
                    mkdir($expectedDir, 0755, true);
                }
                // Copy template.json to expected location
                copy($tempDir . '/template.json', "$expectedDir/template.json");
                // Move all other root files into the theme dir (skip __MACOSX)
                $items = glob($tempDir . '/*');
                foreach ($items as $item) {
                    $basename = basename($item);
                    if ($basename === 'themes' || $basename === '__MACOSX' || $basename === 'template.json') {
                        continue;
                    }
                    $dest = "$expectedDir/$basename";
                    if (!file_exists($dest)) {
                        rename($item, $dest);
                    }
                }
                return $expectedDir;
            }
        }

        // 3. Try nested single-directory: {somedir}/template.json or {somedir}/themes/{name}/template.json
        $rootDirs = glob($tempDir . '/*', GLOB_ONLYDIR);
        foreach ($rootDirs as $dir) {
            $basename = basename($dir);
            if ($basename === '__MACOSX') {
                continue;
            }

            // Check if this dir has template.json directly
            if (file_exists($dir . '/template.json')) {
                $manifest = json_decode(file_get_contents($dir . '/template.json'), true);
                if (isset($manifest['template']['name'])) {
                    $themeName = $manifest['template']['name'];
                    $expectedDir = "$tempDir/themes/$themeName";
                    if (!is_dir($expectedDir)) {
                        mkdir($expectedDir, 0755, true);
                    }
                    copy($dir . '/template.json', "$expectedDir/template.json");
                    // Move contents into the expected structure
                    $items = glob($dir . '/*');
                    foreach ($items as $item) {
                        $itemBasename = basename($item);
                        if ($itemBasename === 'template.json') {
                            continue;
                        }
                        $dest = "$expectedDir/$itemBasename";
                        if (!file_exists($dest)) {
                            rename($item, $dest);
                        }
                    }
                    return $expectedDir;
                }
            }

            // Check for themes/{name}/template.json inside subdirectory
            $innerThemesDir = $dir . '/themes';
            if (is_dir($innerThemesDir)) {
                $innerDirs = glob($innerThemesDir . '/*', GLOB_ONLYDIR);
                foreach ($innerDirs as $innerDir) {
                    if (file_exists($innerDir . '/template.json')) {
                        return $innerDir;
                    }
                }
            }
        }

        return null;
    }

    public function validateStructure(string $tempDir, TemplateManifestDTO $manifest): array
    {
        $errors = [];

        $themeName = $manifest->name;
        $themeDir = "$tempDir/themes/$themeName";

        // Check theme directory exists
        if (!is_dir($themeDir)) {
            $errors[] = "Theme directory themes/$themeName/ not found in ZIP";
        }

        // Check template.json exists
        if (!file_exists("$themeDir/template.json")) {
            $errors[] = 'template.json not found in theme directory';
        }

        // Check context directories
        foreach ($manifest->contexts as $context) {
            if (!is_dir("$themeDir/$context")) {
                $errors[] = "Context '$context' declared but directory themes/$themeName/$context/ not found";
            }
        }

        // Check for files outside allowed paths
        $allowedPaths = [
            "themes/$themeName/",
            "public/assets/theme/$themeName/",
        ];

        try {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($tempDir, RecursiveDirectoryIterator::SKIP_DOTS)
            );

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $relativePath = str_replace($tempDir . '/', '', $file->getPathname());
                    $isAllowed = false;

                    foreach ($allowedPaths as $path) {
                        if (str_starts_with($relativePath, $path)) {
                            $isAllowed = true;
                            break;
                        }
                    }

                    if (!$isAllowed) {
                        $errors[] = "File outside allowed paths: $relativePath";
                    }
                }
            }
        } catch (\Exception $e) {
            $errors[] = "Failed to validate directory structure: " . $e->getMessage();
        }

        return $errors;
    }

    public function checkAssets(string $tempDir, string $themeName): ?ThemeUploadWarningDTO
    {
        $assetsDir = "$tempDir/public/assets/theme/$themeName";

        if (!is_dir($assetsDir)) {
            return new ThemeUploadWarningDTO(
                type: 'missing_assets',
                severity: 'warning',
                message: 'No assets directory found in ZIP. Theme may not display correctly.',
                details: ['expected_path' => "public/assets/theme/$themeName/"]
            );
        }

        return null;
    }
}

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
        // 1. Standard structure: themes/{name}/template.json
        $themesDir = $tempDir . '/themes';
        if (is_dir($themesDir)) {
            $dirs = glob($themesDir . '/*', GLOB_ONLYDIR);
            foreach ($dirs as $dir) {
                if (file_exists($dir . '/template.json')) {
                    return $dir;
                }
            }
        }

        // 2. Flat structure: template.json at root level
        if (file_exists($tempDir . '/template.json')) {
            return $this->restructureFlatTheme($tempDir, $tempDir);
        }

        // 3. Nested: {somedir}/template.json or {somedir}/themes/{name}/template.json
        $rootDirs = glob($tempDir . '/*', GLOB_ONLYDIR);
        foreach ($rootDirs as $dir) {
            $basename = basename($dir);
            if ($basename === '__MACOSX') {
                continue;
            }

            // Check for {subdir}/template.json
            if (file_exists($dir . '/template.json')) {
                return $this->restructureFlatTheme($dir, $tempDir);
            }

            // Check for {subdir}/themes/{name}/template.json
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

    /**
     * Restructure a flat theme into the expected themes/{name}/ format.
     * Handles both root-level and subdirectory-level flat themes.
     */
    private function restructureFlatTheme(string $themeSourceDir, string $tempDir): ?string
    {
        $content = @file_get_contents($themeSourceDir . '/template.json');
        if ($content === false) {
            return null;
        }

        $data = json_decode($content, true);
        if (!is_array($data) || !isset($data['template']['name'])) {
            return null;
        }

        $themeName = $data['template']['name'];
        $targetDir = $tempDir . '/themes/' . $themeName;

        // If already restructured, just return it
        if (is_dir($targetDir) && file_exists($targetDir . '/template.json')) {
            return $targetDir;
        }

        // Create the themes/{name}/ directory
        if (!is_dir($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }

        // Copy all files and directories from source into target
        $this->copyDirectoryContents($themeSourceDir, $targetDir);

        // Verify it worked
        if (file_exists($targetDir . '/template.json')) {
            return $targetDir;
        }

        return null;
    }

    /**
     * Recursively copy directory contents from source to destination.
     */
    private function copyDirectoryContents(string $source, string $dest): void
    {
        if (!is_dir($source)) {
            return;
        }

        $items = @scandir($source);
        if ($items === false) {
            return;
        }

        foreach ($items as $item) {
            if ($item === '.' || $item === '..' || $item === '__MACOSX') {
                continue;
            }

            $srcPath = $source . '/' . $item;
            $dstPath = $dest . '/' . $item;

            if (is_dir($srcPath)) {
                if (!is_dir($dstPath)) {
                    @mkdir($dstPath, 0755, true);
                }
                $this->copyDirectoryContents($srcPath, $dstPath);
            } else {
                if (!file_exists($dstPath)) {
                    @copy($srcPath, $dstPath);
                }
            }
        }
    }

    public function validateStructure(string $tempDir, TemplateManifestDTO $manifest): array
    {
        $errors = [];
        $themeName = $manifest->name;
        $themeDir = "$tempDir/themes/$themeName";

        // Check theme directory exists
        if (!is_dir($themeDir)) {
            $errors[] = "Theme directory themes/$themeName/ not found in ZIP";
            return $errors;
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

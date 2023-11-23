<?php

namespace FreshAdvance\Sitemap\Service;

// todo: ensure directory exists
class Filesystem implements FilesystemInterface
{
    public function __construct()
    {
    }

    public function createSitemapFile(string $directory, string $fileName, string $content): string
    {
        $filePath = $directory . DIRECTORY_SEPARATOR . $fileName;
        file_put_contents($filePath, $content);

        return $filePath;
    }

    public function cleanupSitemapFiles(string $directory): void
    {
        $allFiles = scandir($directory);

        if (!is_array($allFiles)) {
            return;
        }

        foreach ($allFiles as $oneFile) {
            if (preg_match("@^sitemap.*?\.xml(\.gz)?$@si", $oneFile)) {
                unlink($directory . DIRECTORY_SEPARATOR . $oneFile);
            }
        }
    }
}

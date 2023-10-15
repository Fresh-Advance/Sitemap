<?php

namespace FreshAdvance\Sitemap\Service;

class Filesystem
{
    public function __construct(
        private ModuleSettings $moduleSettings
    ) {
    }

    public function createSitemapFile(string $fileName, string $content): void
    {
        $filePath = $this->moduleSettings->getSitemapDirectory() . DIRECTORY_SEPARATOR . $fileName;
        file_put_contents($filePath, $content);
    }
}

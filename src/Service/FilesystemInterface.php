<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Service;

interface FilesystemInterface
{
    public function createSitemapFile(string $directory, string $fileName, string $content): string;

    public function cleanupSitemapFiles(string $directory): void;
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\SitemapUrlInterface;

interface LocationServiceInterface
{
    public function getSitemapDirectoryPath(): string;

    public function getSitemapFileUrl(string $fileName): SitemapUrlInterface;
}

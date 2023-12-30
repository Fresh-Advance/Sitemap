<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Sitemap\Service;

use FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrlInterface;

interface LocationServiceInterface
{
    public function getSitemapDirectoryPath(): string;

    public function getSitemapFileUrl(string $fileName): SitemapUrlInterface;
}

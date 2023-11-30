<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Settings;

use FreshAdvance\Sitemap\DataStructure\SitemapUrlInterface;

interface LocationServiceInterface
{
    public function getSitemapDirectoryPath(): string;

    public function getSitemapFileUrl(string $fileName): SitemapUrlInterface;
}

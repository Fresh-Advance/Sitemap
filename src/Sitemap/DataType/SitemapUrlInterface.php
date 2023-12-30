<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Sitemap\DataType;

use DateTimeInterface;

interface SitemapUrlInterface
{
    public function getLocation(): string;

    public function getLastModified(): DateTimeInterface;
}

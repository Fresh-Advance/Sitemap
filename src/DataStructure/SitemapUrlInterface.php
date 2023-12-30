<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\DataStructure;

use DateTimeInterface;

interface SitemapUrlInterface
{
    public function getLocation(): string;

    public function getLastModified(): DateTimeInterface;
}

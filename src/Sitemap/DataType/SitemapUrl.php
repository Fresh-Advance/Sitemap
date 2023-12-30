<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Sitemap\DataType;

use DateTimeInterface;

class SitemapUrl implements SitemapUrlInterface
{
    public function __construct(
        protected string $location,
        protected DateTimeInterface $lastModified
    ) {
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getLastModified(): DateTimeInterface
    {
        return $this->lastModified;
    }
}

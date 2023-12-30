<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Url\DataType;

use DateTimeInterface;
use FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrl;

class Url extends SitemapUrl implements UrlInterface
{
    public function __construct(
        protected string $location,
        protected DateTimeInterface $lastModified,
        protected string $changeFrequency,
        protected float $priority
    ) {
        parent::__construct(
            location: $this->location,
            lastModified: $this->lastModified
        );
    }

    public function getChangeFrequency(): string
    {
        return $this->changeFrequency;
    }

    public function getPriority(): float
    {
        return $this->priority;
    }
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Url\DataType;

class UrlType implements UrlTypeInterface
{
    public function __construct(
        protected string $objectType,
        protected string $changeFrequency,
        protected float $priority
    ) {
    }

    public function getObjectType(): string
    {
        return $this->objectType;
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

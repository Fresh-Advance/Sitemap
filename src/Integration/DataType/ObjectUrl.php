<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Integration\DataType;

use DateTimeInterface;

class ObjectUrl implements ObjectUrlInterface
{
    public function __construct(
        private string $objectId,
        private string $objectType,
        private string $location,
        private DateTimeInterface $modified,
    ) {
    }

    public function getObjectId(): string
    {
        return $this->objectId;
    }

    public function getObjectType(): string
    {
        return $this->objectType;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getModified(): DateTimeInterface
    {
        return $this->modified;
    }
}

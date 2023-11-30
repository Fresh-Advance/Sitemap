<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\DataStructure;

class ObjectUrl implements ObjectUrlInterface
{
    public function __construct(
        private string $objectId,
        private string $objectType,
        private PageUrlInterface $url
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

    public function getUrl(): PageUrlInterface
    {
        return $this->url;
    }
}

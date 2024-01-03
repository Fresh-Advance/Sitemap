<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter\Shared;

use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;

abstract class BaseChangeFilter implements ChangeFilterInterface
{
    public function __construct(
        protected string $objectType
    ) {
    }

    public function getObjectType(): string
    {
        return $this->objectType;
    }

    abstract public function getUpdatedUrls(int $limit): iterable;
}

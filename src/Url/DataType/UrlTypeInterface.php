<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Url\DataType;

interface UrlTypeInterface
{
    public function getObjectType(): string;

    public function getChangeFrequency(): string;

    public function getPriority(): float;
}

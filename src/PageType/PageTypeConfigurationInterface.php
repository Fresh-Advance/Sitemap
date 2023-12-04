<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\PageType;

interface PageTypeConfigurationInterface
{
    public function getObjectType(): string;

    public function getChangeFrequency(): string;

    public function getPriority(): float;
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Url\DataType;

use DateTimeInterface;

interface UrlInterface
{
    public function getLocation(): string;

    public function getLastModified(): DateTimeInterface;

    public function getChangeFrequency(): string;

    public function getPriority(): float;
}

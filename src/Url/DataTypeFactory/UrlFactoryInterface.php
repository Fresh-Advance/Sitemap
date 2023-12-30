<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Url\DataTypeFactory;

use DateTime;
use FreshAdvance\Sitemap\Url\DataType\UrlInterface;

interface UrlFactoryInterface
{
    public function createUrl(string $type, string $url, DateTime $modified): UrlInterface;
}

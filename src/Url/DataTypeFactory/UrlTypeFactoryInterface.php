<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Url\DataTypeFactory;

use FreshAdvance\Sitemap\Url\DataType\UrlTypeInterface;

interface UrlTypeFactoryInterface
{
    public function getConfiguration(string $string): UrlTypeInterface;
}

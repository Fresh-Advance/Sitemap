<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;

interface UrlFactoryInterface
{
    public function createUrl(string $type, string $url, \DateTime $modified): PageUrlInterface;
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\SitemapUrlInterface;
use FreshAdvance\Sitemap\Url\DataType\UrlInterface;

interface XmlGeneratorInterface
{
    /**
     * @param iterable<UrlInterface> $items
     */
    public function generateSitemapDocument(iterable $items): string;

    /**
     * @param iterable<SitemapUrlInterface> $items
     */
    public function generateSitemapIndexDocument(iterable $items): string;
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;
use FreshAdvance\Sitemap\DataStructure\SitemapUrlInterface;

interface XmlGeneratorInterface
{
    /**
     * @param iterable<PageUrlInterface> $items
     */
    public function generateSitemapDocument(iterable $items): string;

    /**
     * @param iterable<SitemapUrlInterface> $items
     */
    public function generateSitemapIndexDocument(iterable $items): string;
}

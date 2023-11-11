<?php

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\ObjectUrlInterface;

interface XmlGeneratorInterface
{
    /**
     * @param iterable<ObjectUrlInterface> $items
     */
    public function generateSitemapDocument(iterable $items): string;
}

<?php

namespace FreshAdvance\Sitemap\Service;

interface XmlGeneratorInterface
{
    public function generateSitemapDocument(iterable $items): string;
}

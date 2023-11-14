<?php

namespace FreshAdvance\Sitemap\DataStructure;

interface PageUrlInterface extends SitemapUrlInterface
{
    public function getChangeFrequency(): string;

    public function getPriority(): float;
}

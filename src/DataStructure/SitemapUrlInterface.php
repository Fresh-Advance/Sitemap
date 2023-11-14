<?php

namespace FreshAdvance\Sitemap\DataStructure;

interface SitemapUrlInterface
{
    public function getLocation(): string;

    public function getLastModified(): string;
}

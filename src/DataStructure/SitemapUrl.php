<?php

namespace FreshAdvance\Sitemap\DataStructure;

class SitemapUrl implements SitemapUrlInterface
{
    public function __construct(
        protected string $location,
        protected string $lastModified
    ) {
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getLastModified(): string
    {
        return $this->lastModified;
    }
}

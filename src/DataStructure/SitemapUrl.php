<?php

namespace FreshAdvance\Sitemap\DataStructure;

class SitemapUrl implements SitemapUrlInterface
{
    public function __construct(
        protected string $location,
        protected \DateTimeInterface $lastModified
    ) {
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getLastModified(): \DateTimeInterface
    {
        return $this->lastModified;
    }
}

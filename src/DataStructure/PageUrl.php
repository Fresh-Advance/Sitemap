<?php

namespace FreshAdvance\Sitemap\DataStructure;

class PageUrl extends SitemapUrl implements PageUrlInterface
{
    public function __construct(
        protected string $location,
        protected \DateTimeInterface $lastModified,
        protected string $changeFrequency,
        protected float $priority
    ) {
        parent::__construct(
            location: $this->location,
            lastModified: $this->lastModified
        );
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getLastModified(): \DateTimeInterface
    {
        return $this->lastModified;
    }

    public function getChangeFrequency(): string
    {
        return $this->changeFrequency;
    }

    public function getPriority(): float
    {
        return $this->priority;
    }
}

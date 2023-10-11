<?php

namespace FreshAdvance\Sitemap\DataStructure;

class Url implements UrlInterface
{
    public function __construct(
        protected string $location,
        protected string $lastModified,
        protected string $changeFrequency,
        protected float $priority
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

    public function getChangeFrequency(): string
    {
        return $this->changeFrequency;
    }

    public function getPriority(): float
    {
        return $this->priority;
    }
}

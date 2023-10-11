<?php

namespace FreshAdvance\Sitemap\DataStructure;

interface UrlInterface
{
    public function getLocation(): string;

    public function getLastModified(): string;

    public function getChangeFrequency(): string;

    public function getPriority(): float;
}

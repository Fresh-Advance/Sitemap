<?php

namespace FreshAdvance\Sitemap\Repository;

use FreshAdvance\Sitemap\DataStructure\UrlInterface;

interface UrlRepositoryInterface
{
    public function addUrl(string $objectId, string $objectType, UrlInterface $urlData): void;

    public function getUrl(string $objectId, string $objectType): ?UrlInterface;

    public function getUrlsByType(string $objectType, int $page, int $perPage): iterable;
}

<?php

namespace FreshAdvance\Sitemap\Repository;

use FreshAdvance\Sitemap\DataStructure\Url;

interface UrlRepositoryInterface
{
    public function addUrl(string $objectId, string $objectType, Url $urlData): void;

    public function getUrl(string $objectId, string $objectType): ?Url;
}

<?php

namespace FreshAdvance\Sitemap\Repository;

use FreshAdvance\Sitemap\DataStructure\ObjectUrlInterface;
use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;

interface UrlRepositoryInterface
{
    public function addObjectUrl(ObjectUrlInterface $objectUrl): void;

    public function getUrl(string $objectId, string $objectType): ?PageUrlInterface;

    /**
     * @return iterable<PageUrlInterface>
     */
    public function getUrlsByType(string $objectType, int $page, int $perPage): iterable;
}

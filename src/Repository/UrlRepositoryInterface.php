<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

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
    public function getUrls(int $page, int $perPage): iterable;

    public function getUrlsCount(): int;
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Url\Repository;

use FreshAdvance\Sitemap\Integration\DataType\ObjectUrlInterface;
use FreshAdvance\Sitemap\Url\DataType\UrlInterface;

interface UrlRepositoryInterface
{
    public function addObjectUrl(ObjectUrlInterface $objectUrl): void;

    public function getUrl(string $objectId, string $objectType): ?UrlInterface;

    /**
     * @return iterable<\FreshAdvance\Sitemap\Url\DataType\UrlInterface>
     */
    public function getUrls(int $page, int $perPage): iterable;

    public function getUrlsCount(): int;

    public function deleteByIds(array $ids): void;
}

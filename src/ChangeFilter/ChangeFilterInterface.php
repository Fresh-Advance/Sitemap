<?php

namespace FreshAdvance\Sitemap\ChangeFilter;

use FreshAdvance\Sitemap\DataStructure\ObjectUrlInterface;

interface ChangeFilterInterface
{
    public function getObjectType(): string;

    /**
     * @return iterable<ObjectUrlInterface>
     */
    public function getUpdatedUrls(int $limit): iterable;
}

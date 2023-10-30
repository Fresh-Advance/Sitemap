<?php

namespace FreshAdvance\Sitemap\ChangeFilter;

interface ChangeFilterInterface
{
    public function getObjectType(): string;

    public function getUpdatedUrls(int $limit): \Generator;
}

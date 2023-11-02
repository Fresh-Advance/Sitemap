<?php

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\ChangeFilter\ChangeFilterInterface;

interface FilterServiceInterface
{
    public function getFilter(string $objectType): ChangeFilterInterface;
}

<?php

namespace FreshAdvance\Sitemap\ChangeFilter;

interface FilterServiceInterface
{
    public function getFilter(string $objectType): ChangeFilterInterface;
}

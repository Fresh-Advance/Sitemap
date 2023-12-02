<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\ChangeFilter;

interface FilterFactoryInterface
{
    public function getFilter(string $objectType): ChangeFilterInterface;
}

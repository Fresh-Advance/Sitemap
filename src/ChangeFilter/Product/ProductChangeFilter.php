<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter\Product;

use FreshAdvance\Sitemap\ChangeFilter\Shared\DatabaseChangeFilter;

class ProductChangeFilter extends DatabaseChangeFilter
{
    public function getUpdatedUrls(int $limit): iterable
    {
        return $this->queryAndFetchObjectUrl($this->getQuery('oxarticles', $limit), $this->getQueryParameters());
    }
}

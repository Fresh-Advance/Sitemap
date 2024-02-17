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
        return $this->queryAndFetchModelObjectUrl(
            query: $this->getSelectModelQuery('oxarticles', $limit),
            queryParameters: $this->getQueryParameters()
        );
    }

    public function getDisabledUrlIds(): array
    {
        return $this->queryAndFetchDisabledSitemapObjectUrlIds('product', 'oxarticles');
    }
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter;

use OxidEsales\Eshop\Application\Model\Category;

class CategoryChangeFilter extends ChangeFilterTemplate implements ChangeFilterInterface
{
    public function getUpdatedUrls(int $limit): iterable
    {
        return $this->queryAndFetchObjectUrl($this->getQuery('oxcategories', $limit), $this->getQueryParameters());
    }

    protected function getModelClass(): string
    {
        return Category::class;
    }
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter\Category;

use FreshAdvance\Sitemap\ChangeFilter\Shared\ChangeFilterTemplate;
use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;

class CategoryChangeFilter extends ChangeFilterTemplate implements ChangeFilterInterface
{
    public function getUpdatedUrls(int $limit): iterable
    {
        return $this->queryAndFetchObjectUrl($this->getQuery('oxcategories', $limit), $this->getQueryParameters());
    }
}

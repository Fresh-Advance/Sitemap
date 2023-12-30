<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter;

use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;

class ProductChangeFilter extends ChangeFilterTemplate implements ChangeFilterInterface
{
    public function getUpdatedUrls(int $limit): iterable
    {
        return $this->queryAndFetchObjectUrl($this->getQuery('oxarticles', $limit), $this->getQueryParameters());
    }
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter\Content;

use FreshAdvance\Sitemap\ChangeFilter\Shared\DatabaseChangeFilter;

class ContentChangeFilter extends DatabaseChangeFilter
{
    public function getUpdatedUrls(int $limit): iterable
    {
        return $this->queryAndFetchObjectUrl($this->getQuery('oxcontents', $limit), $this->getQueryParameters());
    }

    protected function getQueryParameters(): array
    {
        $queryParemeters = parent::getQueryParameters();

        $queryParemeters['oxfolder'] = 'CMSFOLDER_USERINFO';
        $queryParemeters['oxactive'] = true;

        return $queryParemeters;
    }

    protected function getQueryCondition(): string
    {
        return "c.OXFOLDER = :oxfolder AND c.OXACTIVE = :oxactive";
    }
}

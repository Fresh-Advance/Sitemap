<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter;

use Doctrine\DBAL\ForwardCompatibility\Result;
use OxidEsales\Eshop\Application\Model\Article;

class ProductChangeFilter extends ChangeFilterTemplate implements ChangeFilterInterface
{
    protected function getModelClass(): string
    {
        return Article::class;
    }

    public function getUpdatedUrls(int $limit): iterable
    {
        return $this->queryAndFetchObjectUrl($this->getQuery('oxarticles', $limit), $this->getQueryParameters());
    }
}

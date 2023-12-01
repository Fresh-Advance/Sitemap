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
    public function getObjectType(): string
    {
        return 'product';
    }

    protected function filterAndQueryItems(int $limit): Result
    {
        $query = "SELECT a.OXID
            FROM oxarticles a
            WHERE a.OXACTIVE = :oxactive
                AND a.OXTIMESTAMP > COALESCE(
              (SELECT MAX(modified) FROM fa_sitemap WHERE object_type = :object_type),
              '1970-01-01'
            )
            ORDER BY a.OXTIMESTAMP ASC
            LIMIT {$limit}";

        /** @var Result $result */
        $result = $this->connection->executeQuery(
            $query,
            [
                'object_type' => $this->getObjectType(),
                'oxactive' => true,
            ]
        );

        return $result;
    }

    protected function getModelClass(): string
    {
        return Article::class;
    }

    protected function getChangeFrequency(): string
    {
        return 'daily';
    }

    protected function getPriority(): float
    {
        return 0.5;
    }
}

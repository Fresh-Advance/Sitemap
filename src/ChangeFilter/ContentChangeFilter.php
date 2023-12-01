<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter;

use Doctrine\DBAL\ForwardCompatibility\Result;
use OxidEsales\Eshop\Application\Model\Content;

class ContentChangeFilter extends ChangeFilterTemplate implements ChangeFilterInterface
{
    public function getObjectType(): string
    {
        return 'content';
    }

    protected function filterAndQueryItems(int $limit): Result
    {
        $query = "SELECT c.OXID
            FROM oxcontents c
            WHERE c.OXFOLDER = :oxfolder
                AND c.OXACTIVE = :oxactive
                AND c.OXTIMESTAMP > COALESCE(
              (SELECT MAX(modified) FROM fa_sitemap WHERE object_type = :object_type),
              '1970-01-01'
            )
            ORDER BY c.OXTIMESTAMP ASC
            LIMIT {$limit}";

        /** @var Result $result */
        $result = $this->connection->executeQuery(
            $query,
            [
                'object_type' => $this->getObjectType(),
                'oxfolder' => 'CMSFOLDER_USERINFO',
                'oxactive' => true,
            ]
        );

        return $result;
    }

    protected function getModelClass(): string
    {
        return Content::class;
    }

    protected function getChangeFrequency(): string
    {
        return 'weekly';
    }

    protected function getPriority(): float
    {
        return 0.3;
    }
}

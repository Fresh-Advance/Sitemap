<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter;

use DateTime;
use Doctrine\DBAL\Connection;
use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrl;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;

class CategoryChangeFilter implements ChangeFilterInterface
{
    protected Connection $connection;

    public function __construct(
        ConnectionProviderInterface $connectionProvider
    ) {
        $this->connection = $connectionProvider->get();
    }

    public function getObjectType(): string
    {
        return 'category';
    }

    public function getUpdatedUrls(int $limit): iterable
    {
        $query = "SELECT c.OXID
            FROM oxcategories c
            WHERE c.OXACTIVE = :oxactive
                AND c.OXTIMESTAMP > COALESCE(
              (SELECT MAX(modified) FROM fa_sitemap WHERE object_type = :object_type),
              '1970-01-01'
            )
            ORDER BY c.OXTIMESTAMP ASC
            LIMIT {$limit}";

        $result = $this->connection->executeQuery(
            $query,
            [
                'object_type' => $this->getObjectType(),
                'oxactive' => true,
            ]
        );

        while ($data = $result->fetchAssociative()) {
            $item = oxNew(Category::class);
            $item->load((string)$data['OXID']); // @phpstan-ignore-line

            yield new ObjectUrl(
                objectId: $item->getId(),
                objectType: $this->getObjectType(),
                url: new PageUrl(
                    location: (string)$item->getLink(),
                    lastModified: new DateTime($item->getFieldData('oxtimestamp')), // @phpstan-ignore-line
                    changeFrequency: 'daily',
                    priority: 0.9
                )
            );
        }
    }
}

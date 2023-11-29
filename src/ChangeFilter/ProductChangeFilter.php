<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter;

use DateTime;
use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrl;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;
use Doctrine\DBAL\Connection;

class ProductChangeFilter implements ChangeFilterInterface
{
    protected Connection $connection;

    public function __construct(
        ConnectionProviderInterface $connectionProvider
    ) {
        $this->connection = $connectionProvider->get();
    }

    public function getObjectType(): string
    {
        return 'product';
    }

    public function getUpdatedUrls(int $limit): iterable
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

        $result = $this->connection->executeQuery(
            $query,
            [
                'object_type' => $this->getObjectType(),
                'oxactive' => true,
            ]
        );

        while ($data = $result->fetchAssociative()) {
            $item = oxNew(Article::class);
            $item->load((string)$data['OXID']); // @phpstan-ignore-line

            yield new ObjectUrl(
                objectId: $item->getId(),
                objectType: $this->getObjectType(),
                url: new PageUrl(
                    location: (string)$item->getLink(),
                    lastModified: new DateTime($item->getFieldData('oxtimestamp')), // @phpstan-ignore-line
                    changeFrequency: 'daily',
                    priority: 0.7
                )
            );
        }
    }
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter\Shared;

use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ForwardCompatibility\Result;
use FreshAdvance\Sitemap\ChangeFilter\Shared\Repository\ModelItemRepositoryInterface;
use FreshAdvance\Sitemap\Integration\DataType\ObjectUrl;
use Generator;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;

abstract class DatabaseChangeFilter extends BaseChangeFilter
{
    protected Connection $connection;

    public function __construct(
        ConnectionProviderInterface $connectionProvider,
        protected string $objectType,
        protected ModelItemRepositoryInterface $modelItemRepository,
    ) {
        parent::__construct(
            objectType: $this->objectType
        );

        $this->connection = $connectionProvider->get();
    }

    public function queryAndFetchObjectUrl(string $query, array $queryParameters): Generator
    {
        /** @var Result $result */
        $result = $this->connection->executeQuery(
            $query,
            $queryParameters
        );

        while ($data = $result->fetchAssociative()) {
            /** @var array{OXID:string} $data */

            $item = $this->modelItemRepository->getItem($data['OXID']);

            /** @var string $timestamp */
            $timestamp = $item->getFieldData('oxtimestamp');

            yield new ObjectUrl(
                objectId: $item->getId(),
                objectType: $this->getObjectType(),
                location: $item->getLink(),
                modified: new DateTime($timestamp)
            );
        }
    }

    protected function getQueryParameters(): array
    {
        return [
            'object_type' => $this->getObjectType(),
            'oxactive' => true,
        ];
    }

    protected function getQuery(string $table, int $limit): string
    {
        $query = "SELECT c.OXID
            FROM {$table} c
            WHERE " . $this->getQueryCondition() . " AND c.OXTIMESTAMP > COALESCE(
                  (SELECT MAX(modified) FROM fa_sitemap WHERE object_type = :object_type),
                  '1970-01-01'
                )
            ORDER BY c.OXTIMESTAMP ASC
            LIMIT {$limit}";
        return $query;
    }

    protected function getQueryCondition(): string
    {
        return "c.OXACTIVE = :oxactive";
    }
}

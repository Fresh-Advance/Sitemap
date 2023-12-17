<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter;

use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ForwardCompatibility\Result;
use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrl;
use FreshAdvance\Sitemap\PageType\PageTypeConfigurationInterface;
use FreshAdvance\Sitemap\Repository\ModelItemRepositoryInterface;
use OxidEsales\EshopCommunity\Core\Contract\IUrl;
use OxidEsales\EshopCommunity\Core\Model\BaseModel;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;

abstract class ChangeFilterTemplate
{
    protected Connection $connection;

    public function __construct(
        ConnectionProviderInterface $connectionProvider,
        protected PageTypeConfigurationInterface $pageTypeConfiguration,
        protected ModelItemRepositoryInterface $modelItemRepository,
    ) {
        $this->connection = $connectionProvider->get();
    }

    public function queryAndFetchObjectUrl(string $query, array $queryParameters): \Generator
    {
        /** @var Result $result */
        $result = $this->connection->executeQuery(
            $query,
            $queryParameters
        );

        while ($data = $result->fetchAssociative()) {
            /** @var array{OXID:string} $data */

            $item = $this->modelItemRepository->getItem($data['OXID']);

            yield new ObjectUrl(
                objectId: $item->getId(),
                objectType: $this->getObjectType(),
                location: $item->getLink(),
                modified: new DateTime($item->getFieldData('oxtimestamp'))
            );
        }
    }

    public function getObjectType(): string
    {
        return $this->pageTypeConfiguration->getObjectType();
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

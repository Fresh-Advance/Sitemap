<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Url\Repository;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Result;
use FreshAdvance\Sitemap\DataStructure\ObjectUrlInterface;
use FreshAdvance\Sitemap\Url\DataType\UrlInterface;
use FreshAdvance\Sitemap\Url\DataTypeFactory\UrlFactoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class UrlRepository implements UrlRepositoryInterface
{
    public function __construct(
        protected QueryBuilderFactoryInterface $queryBuilderFactory,
        protected UrlFactoryInterface $urlFactory,
    ) {
    }

    public function addObjectUrl(ObjectUrlInterface $objectUrl): void
    {
        $connection = $this->queryBuilderFactory->create()->getConnection();
        $sql = "INSERT INTO fa_sitemap SET
                  object_id = :object_id,
                  object_type = :object_type,
                  location = :location,
                  modified = :modified
                ON DUPLICATE KEY UPDATE
                  location = :location,
                  modified = :modified";

        $connection->executeQuery($sql, [
            'object_id' => $objectUrl->getObjectId(),
            'object_type' => $objectUrl->getObjectType(),
            'location' => $objectUrl->getLocation(),
            'modified' => $objectUrl->getModified()->format(DateTimeInterface::ATOM)
        ]);
    }

    public function getUrl(string $objectId, string $objectType): ?UrlInterface
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->select('*')
            ->from('fa_sitemap')
            ->where('object_id = :object_id AND object_type = :object_type')
            ->setParameters([
                'object_id' => $objectId,
                'object_type' => $objectType,
            ]);

        /** @var Result $result */
        $result = $queryBuilder->execute();

        /** @var false|array<string, int|string|bool|null> $data */
        $data = $result->fetchAssociative();
        if (is_array($data)) {
            return $this->urlFactory->createUrl(
                type: (string)$data['object_type'],
                url: (string)$data['location'],
                modified: new DateTime((string)$data['modified']),
            );
        }

        return null;
    }

    public function getUrls(int $page, int $perPage): iterable
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->select('*')
            ->from('fa_sitemap')
            ->orderBy("id")
            ->setFirstResult(--$page * $perPage)
            ->setMaxResults($perPage);

        /** @var Result $result */
        $result = $queryBuilder->execute();

        while ($data = $result->fetchAssociative()) {
            /** @var array<string, int|string|bool> $data */
            yield $this->urlFactory->createUrl(
                type: (string)$data['object_type'],
                url: (string)$data['location'],
                modified: new DateTime((string)$data['modified']),
            );
        }
    }

    public function getUrlsCount(): int
    {
        $queryBuilder = $this->queryBuilderFactory->create();
        $queryBuilder->select('count(*)')->from('fa_sitemap');

        /** @var Result $queryResult */
        $queryResult = $queryBuilder->execute();

        /** @var int|string|null|false $value */
        $value = $queryResult->fetchOne();

        return (int)$value;
    }
}

<?php

namespace FreshAdvance\Sitemap\Repository;

use Doctrine\DBAL\Result;
use FreshAdvance\Sitemap\DataStructure\ObjectUrlInterface;
use FreshAdvance\Sitemap\DataStructure\PageUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class UrlRepository implements UrlRepositoryInterface
{
    public function __construct(
        protected QueryBuilderFactoryInterface $queryBuilderFactory
    ) {
    }

    public function addObjectUrl(ObjectUrlInterface $objectUrl): void
    {
        $connection = $this->queryBuilderFactory->create()->getConnection();
        $sql = "INSERT INTO fa_sitemap SET
                  object_id = :object_id,
                  object_type = :object_type,
                  location = :location,
                  modified = :modified,
                  frequency = :frequency,
                  priority = :priority
                ON DUPLICATE KEY UPDATE
                  location = :location,
                  modified = :modified,
                  frequency = :frequency,
                  priority = :priority";

        $url = $objectUrl->getUrl();
        $connection->executeQuery($sql, [
            'object_id' => $objectUrl->getObjectId(),
            'object_type' => $objectUrl->getObjectType(),
            'location' => $url->getLocation(),
            'modified' => $url->getLastModified(),
            'frequency' => $url->getChangeFrequency(),
            'priority' => $url->getPriority()
        ]);
    }

    public function getUrl(string $objectId, string $objectType): ?PageUrlInterface
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
            return new PageUrl(
                location: (string)$data['location'],
                lastModified: (string)$data['modified'],
                changeFrequency: (string)$data['frequency'],
                priority: (float)$data['priority'],
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
            yield new PageUrl(
                location: (string)$data['location'],
                lastModified: (string)$data['modified'],
                changeFrequency: (string)$data['frequency'],
                priority: (float)$data['priority'],
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

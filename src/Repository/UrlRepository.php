<?php

namespace FreshAdvance\Sitemap\Repository;

use Doctrine\DBAL\Result;
use FreshAdvance\Sitemap\DataStructure\Url;
use OxidEsales\EshopCommunity\Internal\Framework\Database\QueryBuilderFactoryInterface;

class UrlRepository implements UrlRepositoryInterface
{
    public function __construct(
        protected QueryBuilderFactoryInterface $queryBuilderFactory
    )
    {
    }

    public function addUrl(string $objectId, string $objectType, Url $urlData): void
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

        $connection->executeQuery($sql, [
            'object_id' => $objectId,
            'object_type' => $objectType,
            'location' => $urlData->getLocation(),
            'modified' => $urlData->getLastModified(),
            'frequency' => $urlData->getChangeFrequency(),
            'priority' => $urlData->getPriority()
        ]);
    }

    public function getUrl(string $objectId, string $objectType): ?Url
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
        $data = $result->fetchAssociative();
        if (is_array($data)) {
            return new Url(
                location: $data['location'],
                lastModified: $data['modified'],
                changeFrequency: $data['frequency'],
                priority: $data['priority'],
            );
        }

        return null;
    }
}

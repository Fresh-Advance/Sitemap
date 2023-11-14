<?php

namespace FreshAdvance\Sitemap\ChangeFilter;

use Doctrine\DBAL\Connection;
use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrl;
use OxidEsales\Eshop\Application\Model\Content;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;

class ContentChangeFilter implements ChangeFilterInterface
{
    protected Connection $connection;

    public function __construct(
        ConnectionProviderInterface $connectionProvider
    ) {
        $this->connection = $connectionProvider->get();
    }

    public function getObjectType(): string
    {
        return 'content';
    }

    public function getUpdatedUrls(int $limit): \Generator
    {
        $query = "SELECT c.OXID
            FROM oxcontents c
            WHERE c.OXTIMESTAMP > COALESCE(
              (SELECT MAX(modified) FROM fa_sitemap WHERE object_type = :object_type),
              '1970-01-01'
            )
            ORDER BY c.OXTIMESTAMP ASC
            LIMIT {$limit}";

        $result = $this->connection->executeQuery($query, ['object_type' => $this->getObjectType()]);

        while ($data = $result->fetchAssociative()) {
            $item = oxNew(Content::class);
            $item->load((string)$data['OXID']); // @phpstan-ignore-line

            yield new ObjectUrl(
                objectId: $item->getId(),
                objectType: 'content',
                url: new PageUrl(
                    location: (string)$item->getLink(),
                    lastModified: (string)$item->getFieldData('oxtimestamp'), // @phpstan-ignore-line
                    changeFrequency: 'never',
                    priority: 0.5
                )
            );
        }
    }
}

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
use OxidEsales\EshopCommunity\Core\Contract\IUrl;
use OxidEsales\EshopCommunity\Core\Model\BaseModel;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;

abstract class ChangeFilterTemplate
{
    protected Connection $connection;

    public function __construct(
        ConnectionProviderInterface $connectionProvider,
        protected PageTypeConfigurationInterface $pageTypeConfiguration
    ) {
        $this->connection = $connectionProvider->get();
    }

    public function getObjectType(): string
    {
        return $this->pageTypeConfiguration->getObjectType();
    }

    public function getUpdatedUrls(int $limit): iterable
    {
        $result = $this->filterAndQueryItems($limit);

        while ($data = $result->fetchAssociative()) {
            /** @var array{OXID:string} $data */

            /** @var IUrl&BaseModel $item */
            $item = oxNew($this->getModelClass());
            $item->load($data['OXID']);

            yield new ObjectUrl(
                objectId: $item->getId(),
                objectType: $this->getObjectType(),
                url: new PageUrl(
                    location: $item->getLink(),
                    lastModified: new DateTime($item->getFieldData('oxtimestamp')), // @phpstan-ignore-line
                    changeFrequency: $this->getChangeFrequency(),
                    priority: $this->getPriority()
                )
            );
        }
    }

    abstract protected function filterAndQueryItems(int $limit): Result;

    /**
     * @return class-string
     */
    abstract protected function getModelClass(): string;

    protected function getChangeFrequency(): string
    {
        return $this->pageTypeConfiguration->getChangeFrequency();
    }

    protected function getPriority(): float
    {
        return $this->pageTypeConfiguration->getPriority();
    }
}

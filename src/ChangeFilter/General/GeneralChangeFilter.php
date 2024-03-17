<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter\General;

use DateTime;
use Doctrine\DBAL\Connection;
use FreshAdvance\Sitemap\ChangeFilter\Shared\BaseChangeFilter;
use FreshAdvance\Sitemap\Integration\DataType\ObjectUrl;
use FreshAdvance\Sitemap\Settings\ModuleSettingsInterface;
use FreshAdvance\Sitemap\Settings\ShopSettingsInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;
use Symfony\Component\Filesystem\Path;

class GeneralChangeFilter extends BaseChangeFilter
{
    protected Connection $connection;

    public function __construct(
        string $objectType,
        protected ShopSettingsInterface $shopSettings,
        protected ModuleSettingsInterface $moduleSettings,
        ConnectionProviderInterface $connectionProvider,
    ) {
        parent::__construct($objectType);

        $this->connection = $connectionProvider->get();
    }

    public function getUpdatedUrls(int $limit): \Generator
    {
        $currentUrlKeys = $this->getAdditionalSitemapUrlKeys();

        foreach ($currentUrlKeys as $urlkey => $oneUrl) {
            yield new ObjectUrl(
                objectId: $urlkey,
                objectType: $this->getObjectType(),
                location: $this->prepareUrl($oneUrl),
                modified: new DateTime()
            );
        }
    }

    protected function prepareUrl(string $url): string
    {
        return Path::join(
            rtrim($this->shopSettings->getShopUrl()),
            $url
        );
    }

    public function getDisabledUrlIds(): array
    {
        $currentUrlKeys = array_keys($this->getAdditionalSitemapUrlKeys());

        $queryResult = $this->connection->executeQuery(
            "select id, object_id from fa_sitemap where object_type=:object_type",
            [
                'object_type' => 'general'
            ]
        );
        $dbValues = $queryResult->fetchAllKeyValue();

        $difference = array_diff($dbValues, $currentUrlKeys);

        /** @var array<int> $idsForRemoval */
        $idsForRemoval = array_keys($difference);
        return $idsForRemoval;
    }

    protected function getAdditionalSitemapUrlKeys(): array
    {
        $additionalUrlsList = $this->moduleSettings->getAdditionalSitemapUrls();

        $result = [];
        foreach ($additionalUrlsList as $oneUrl) {
            $result[md5($oneUrl)] = $oneUrl;
        }

        return $result;
    }
}

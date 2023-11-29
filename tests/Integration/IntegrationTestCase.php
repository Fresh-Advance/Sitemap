<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration;

use Doctrine\DBAL\Connection;
use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrl;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;

class IntegrationTestCase extends \OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase
{
    protected function getConnection(): Connection
    {
        return $this->get(ConnectionProviderInterface::class)->get();
    }

    protected function addConcreteDateUrl(string $type, \DateTime $dateTime): void
    {
        /** @var UrlRepositoryInterface $urlRepository */
        $urlRepository = $this->get(UrlRepositoryInterface::class);
        $urlRepository->addObjectUrl(
            new ObjectUrl(
                objectId: 'someId',
                objectType: $type,
                url: new PageUrl(
                    location: 'example',
                    lastModified: $dateTime,
                    changeFrequency: 'frequency',
                    priority: 1
                )
            )
        );
    }
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration;

use Doctrine\DBAL\Connection;
use FreshAdvance\Sitemap\Tests\Integration\Repository\UrlRepositoryTest;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;

class IntegrationTestCase extends \OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase
{
    protected function getConnection(): Connection
    {
        return $this->get(ConnectionProviderInterface::class)->get();
    }
}

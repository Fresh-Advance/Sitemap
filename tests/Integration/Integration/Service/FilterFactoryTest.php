<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\Integration\Service;

use FreshAdvance\Sitemap\Integration\Service\FilterFactoryInterface;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;

class FilterFactoryTest extends IntegrationTestCase
{
    public function testInitialization(): void
    {
        $sut = $this->get(FilterFactoryInterface::class);
        $this->assertInstanceOf(FilterFactoryInterface::class, $sut);
    }
}

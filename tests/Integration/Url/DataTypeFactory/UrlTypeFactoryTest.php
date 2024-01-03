<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\Url\DataTypeFactory;

use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use FreshAdvance\Sitemap\Url\DataTypeFactory\UrlTypeFactoryInterface;

/**
 * @covers \FreshAdvance\Sitemap\Url\DataTypeFactory\UrlTypeFactory
 */
class UrlTypeFactoryTest extends IntegrationTestCase
{
    public function testInitialization(): void
    {
        $sut = $this->get(UrlTypeFactoryInterface::class);
        $this->assertInstanceOf(UrlTypeFactoryInterface::class, $sut);
    }
}

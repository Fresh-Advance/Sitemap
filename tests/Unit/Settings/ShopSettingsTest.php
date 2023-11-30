<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Settings;

use FreshAdvance\Sitemap\Settings\ShopSettings;
use OxidEsales\Eshop\Core\Config;

/**
 * @covers \FreshAdvance\Sitemap\Settings\ShopSettings
 */
class ShopSettingsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetShopUrl(): void
    {
        $shopUrl = 'someShopUrl';

        $shopConfigMock = $this->createStub(Config::class);
        $shopConfigMock->method('getConfigParam')->with('sShopURL')->willReturn($shopUrl);

        $sut = new ShopSettings(
            shopConfig: $shopConfigMock
        );

        $this->assertSame($shopUrl, $sut->getShopUrl());
    }
}

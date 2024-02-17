<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace ChangeFilter\General;

use FreshAdvance\Sitemap\ChangeFilter\General\GeneralChangeFilter;
use FreshAdvance\Sitemap\Integration\DataType\ObjectUrl;
use FreshAdvance\Sitemap\Settings\ShopSettingsInterface;
use PHPUnit\Framework\TestCase;

class GeneralChangeFilterTest extends TestCase
{
    public function testGetUpdatedUrls(): void
    {
        $sut = new GeneralChangeFilter(
            objectType: "someObjectType",
            shopSettings: $shopSettingsStub = $this->createStub(ShopSettingsInterface::class)
        );

        $shopUrlExample = "shopUrlStart";
        $shopSettingsStub->method('getShopUrl')->willReturn($shopUrlExample);

        $count = 0;
        foreach ($sut->getUpdatedUrls(1000) as $oneObjectUrl) {
            $this->assertInstanceOf(ObjectUrl::class, $oneObjectUrl);
            $this->assertStringStartsWith($shopUrlExample, $oneObjectUrl->getLocation());
            $count++;
        }

        $this->assertTrue($count > 0);
    }

    public function testGetDisabledUrls(): void
    {
        $sut = new GeneralChangeFilter(
            objectType: "someObjectType",
            shopSettings: $this->createStub(ShopSettingsInterface::class)
        );

        $this->assertSame([], $sut->getDisabledUrlIds(1000));
    }
}

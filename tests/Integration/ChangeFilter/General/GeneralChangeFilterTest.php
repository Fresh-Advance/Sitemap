<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace ChangeFilter\General;

use FreshAdvance\Sitemap\ChangeFilter\General\GeneralChangeFilter;
use FreshAdvance\Sitemap\Settings\ModuleSettingsInterface;
use FreshAdvance\Sitemap\Settings\ShopSettingsInterface;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use OxidEsales\EshopCommunity\Internal\Framework\Database\ConnectionProviderInterface;

class GeneralChangeFilterTest extends IntegrationTestCase
{
    protected string $objectType = 'general';

    public function testGetUpdatedUrls(): void
    {
        $sut = $this->getSut(
            shopSettings: $shopSettingsStub = $this->createStub(ShopSettingsInterface::class),
            moduleSettings: $moduleSettings = $this->createStub(ModuleSettingsInterface::class),
        );

        $url1 = uniqid();
        $url2 = uniqid();

        $url1hash = md5($url1);
        $url2hash = md5($url2);

        $moduleSettings->method('getAdditionalSitemapUrls')->willReturn([$url1, $url2]);

        $shopUrlExample = "shopUrlStart";
        $shopSettingsStub->method('getShopUrl')->willReturn($shopUrlExample);

        $urls = $sut->getUpdatedUrls(3);

        $urlToTest = $urls->current();
        $this->assertSame($this->objectType, $urlToTest->getObjectType());
        $this->assertSame($url1hash, $urlToTest->getObjectId());
        $this->assertSame($shopUrlExample . '/' . $url1 , $urlToTest->getLocation());
        $this->assertNotEmpty($urlToTest->getModified());

        $urls->next();
        $urlToTest = $urls->current();
        $this->assertSame($this->objectType, $urlToTest->getObjectType());
        $this->assertSame($url2hash, $urlToTest->getObjectId());
        $this->assertSame($shopUrlExample . '/' . $url2 , $urlToTest->getLocation());
        $this->assertNotEmpty($urlToTest->getModified());

        $urls->next();
        $this->assertNull($urls->current());
    }

    public function testGetDisabledUrls(): void
    {
        $connection = $this->getConnection();
        $connection->executeQuery("delete from fa_sitemap");

        $mainPageId = md5('/');
        $connection->executeQuery(
            "insert into fa_sitemap (id, object_id, location, object_type) values
            (998, '$mainPageId', '/', '{$this->objectType}'),
            (999, 'secondobject', 'somelocation2', '{$this->objectType}'),
            (1000, 'thirdobject', 'somelocation3', '{$this->objectType}'),
            (1001, 'fourthobject', 'somelocation4', 'not content')"
        );

        $sut = $this->getSut(
            moduleSettings: $moduleSettings = $this->createStub(ModuleSettingsInterface::class)
        );
        $moduleSettings->method('getAdditionalSitemapUrls')->willReturn(['/']);

        $expectedIds = [999, 1000];
        $this->assertEquals($expectedIds, $sut->getDisabledUrlIds());
    }

    public function getSut(
        ShopSettingsInterface $shopSettings = null,
        ModuleSettingsInterface $moduleSettings = null,
    ): GeneralChangeFilter
    {
        return new GeneralChangeFilter(
            objectType: $this->objectType,
            shopSettings: $shopSettings ?? $this->createStub(ShopSettingsInterface::class),
            moduleSettings: $moduleSettings ?? $this->createStub(ModuleSettingsInterface::class),
            connectionProvider: $this->get(ConnectionProviderInterface::class)
        );
    }
}

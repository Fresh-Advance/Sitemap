<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Sitemap\Service;

use DateTime;
use FreshAdvance\Sitemap\Settings\ModuleSettingsInterface;
use FreshAdvance\Sitemap\Settings\ShopSettingsInterface;
use FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrl;
use FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrlInterface;
use FreshAdvance\Sitemap\Sitemap\Service\LocationService;
use Generator;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Sitemap\Sitemap\Service\LocationService
 */
class LocationServiceTest extends TestCase
{
    /** @dataProvider getSitemapDirectoryPathDataProvider */
    public function testGetSitemapDirectoryPathReturnsCorrectValues(
        string $sourcePath,
        string $sitemapDirectory,
        string $expectedValue
    ): void {
        $sut = $this->getSut(
            basicContext: $basicContextStub = $this->createStub(BasicContextInterface::class),
            moduleSettings: $moduleSettings = $this->createStub(ModuleSettingsInterface::class),
        );

        $basicContextStub->method('getSourcePath')->willReturn($sourcePath);
        $moduleSettings->method('getSitemapInSourceDirectory')->willReturn($sitemapDirectory);

        $this->assertSame($expectedValue, $sut->getSitemapDirectoryPath());
    }

    public function getSitemapDirectoryPathDataProvider(): Generator
    {
        yield 'simple case' => [
            'sourcePath' => 'sourcePath',
            'sitemapDirectory' => 'someSitemapPath',
            'expectedValue' => 'sourcePath/someSitemapPath'
        ];

        yield 'slash in source path end' => [
            'sourcePath' => 'sourcePath/',
            'sitemapDirectory' => 'someSitemapPath',
            'expectedValue' => 'sourcePath/someSitemapPath'
        ];

        yield 'slash in sitemap directory start' => [
            'sourcePath' => 'sourcePath',
            'sitemapDirectory' => '/someSitemapPath',
            'expectedValue' => 'sourcePath/someSitemapPath'
        ];

        yield 'too many slashes' => [
            'sourcePath' => 'sourcePath/',
            'sitemapDirectory' => '/someSitemapPath',
            'expectedValue' => 'sourcePath/someSitemapPath'
        ];

        yield 'source path from root' => [
            'sourcePath' => '/sourcePath/',
            'sitemapDirectory' => '/someSitemapPath/',
            'expectedValue' => '/sourcePath/someSitemapPath'
        ];
    }

    /** @dataProvider getSitemapFileUrlDataProvider */
    public function testGetSitemapFileUrlReturnsCorrectValues(
        string $shopUrl,
        string $fileName,
        string $sitemapDirectory,
        SitemapUrlInterface $expectedValue
    ): void {
        $sut = $this->getSut(
            moduleSettings: $moduleSettings = $this->createStub(ModuleSettingsInterface::class),
            shopSettings: $shopSettingsStub = $this->createStub(ShopSettingsInterface::class),
        );

        $shopSettingsStub->method('getShopUrl')->willReturn($shopUrl);
        $moduleSettings->method('getSitemapInSourceDirectory')->willReturn($sitemapDirectory);

        $this->assertEquals($expectedValue, $sut->getSitemapFileUrl($fileName));
    }

    public function getSitemapFileUrlDataProvider(): Generator
    {
        yield 'simple case' => [
            'shopUrl' => 'exampleUrl',
            'fileName' => 'someFile.xml',
            'sitemapDirectory' => 'directory',
            'expectedValue' => new SitemapUrl(
                location: 'exampleUrl/directory/someFile.xml',
                lastModified: new DateTime('today')
            )
        ];

        yield 'shop url with multiple slashes' => [
            'shopUrl' => 'exampleUrl/',
            'fileName' => 'someFile.xml',
            'sitemapDirectory' => '/directory/',
            'expectedValue' => new SitemapUrl(
                location: 'exampleUrl/directory/someFile.xml',
                lastModified: new DateTime('today')
            )
        ];
    }

    public function getSut(
        ?BasicContextInterface $basicContext = null,
        ?ModuleSettingsInterface $moduleSettings = null,
        ?ShopSettingsInterface $shopSettings = null,
    ): LocationService {
        return new LocationService(
            basicContext: $basicContext ?? $this->createStub(BasicContextInterface::class),
            moduleSettings: $moduleSettings ?? $this->createStub(ModuleSettingsInterface::class),
            shopSettings: $shopSettings ?? $this->createStub(ShopSettingsInterface::class),
        );
    }
}

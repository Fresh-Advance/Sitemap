<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Settings;

use FreshAdvance\Sitemap\Module;
use FreshAdvance\Sitemap\Settings\ModuleSettings;
use FreshAdvance\Sitemap\Settings\ModuleSettingsInterface;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\String\UnicodeString;

class ModuleSettingsTest extends TestCase
{
    public function testSitemapDirectorySetting(): void
    {
        $sut = $this->getSut(
            shopModuleSettings: $shopModuleSettings = $this->createMock(ModuleSettingServiceInterface::class)
        );

        $directoryPathExample = uniqid();

        $shopModuleSettings->method('getString')
            ->with(ModuleSettings::SETTING_SITEMAP_DIRECTORY, Module::MODULE_ID)
            ->willReturn(new UnicodeString($directoryPathExample));

        $this->assertSame($directoryPathExample, $sut->getSitemapInSourceDirectory());
    }

    public function testGetAdditionalSitemapUrls(): void
    {
        $sut = $this->getSut(
            shopModuleSettings: $shopModuleSettings = $this->createMock(ModuleSettingServiceInterface::class)
        );

        $urlsList = [
            uniqid(),
            uniqid(),
        ];

        $shopModuleSettings->method('getCollection')
            ->with(ModuleSettings::SETTING_ADDITIONAL_SITEMAP_URLS, Module::MODULE_ID)
            ->willReturn($urlsList);

        $this->assertSame($urlsList, $sut->getAdditionalSitemapUrls());
    }

    public function getSut(
        ModuleSettingServiceInterface $shopModuleSettings = null,
    ): ModuleSettingsInterface {
        return new ModuleSettings(
            shopModuleSettings: $shopModuleSettings ?? $this->createStub(ModuleSettingServiceInterface::class)
        );
    }
}

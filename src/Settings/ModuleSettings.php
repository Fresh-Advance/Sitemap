<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Settings;

use FreshAdvance\Sitemap\Module;
use OxidEsales\EshopCommunity\Internal\Framework\Module\Facade\ModuleSettingServiceInterface;

/**
 * @todo: make sitemap setting editable
 */
class ModuleSettings implements ModuleSettingsInterface
{
    public const SETTING_ADDITIONAL_SITEMAP_URLS = 'additionalSitemapUrls';

    public function __construct(
        protected ModuleSettingServiceInterface $shopModuleSettings
    ) {
    }

    public function getSitemapInSourceDirectory(): string
    {
        return 'sitemap';
    }

    public function getAdditionalSitemapUrls(): array
    {
        return $this->shopModuleSettings->getCollection(
            self::SETTING_ADDITIONAL_SITEMAP_URLS,
            Module::MODULE_ID
        );
    }
}

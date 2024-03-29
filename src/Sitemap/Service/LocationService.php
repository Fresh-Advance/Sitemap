<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Sitemap\Service;

use DateTime;
use FreshAdvance\Sitemap\Settings\ModuleSettingsInterface;
use FreshAdvance\Sitemap\Settings\ShopSettingsInterface;
use FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrl;
use FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrlInterface;
use OxidEsales\EshopCommunity\Internal\Transition\Utility\BasicContextInterface;

class LocationService implements LocationServiceInterface
{
    public function __construct(
        protected BasicContextInterface $basicContext,
        protected ModuleSettingsInterface $moduleSettings,
        protected ShopSettingsInterface $shopSettings,
    ) {
    }

    public function getSitemapDirectoryPath(): string
    {
        $sourceDirectory = rtrim($this->basicContext->getSourcePath(), DIRECTORY_SEPARATOR);
        $sitemapDirectory = trim($this->moduleSettings->getSitemapInSourceDirectory(), DIRECTORY_SEPARATOR);

        return $sourceDirectory . DIRECTORY_SEPARATOR . $sitemapDirectory;
    }

    /**
     * @todo: get real file change date
     */
    public function getSitemapFileUrl(string $fileName): SitemapUrlInterface
    {
        $shopUrl = rtrim($this->shopSettings->getShopUrl(), DIRECTORY_SEPARATOR);
        $sitemapDirectory = trim($this->moduleSettings->getSitemapInSourceDirectory(), DIRECTORY_SEPARATOR);
        $fileName = ltrim($fileName, DIRECTORY_SEPARATOR);

        $url = implode(DIRECTORY_SEPARATOR, [$shopUrl, $sitemapDirectory, $fileName]);

        return new SitemapUrl(
            location: $url,
            lastModified: new DateTime('today')
        );
    }
}

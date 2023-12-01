<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Settings;

use OxidEsales\Eshop\Core\Config;

class ShopSettings implements ShopSettingsInterface
{
    public function __construct(
        protected Config $shopConfig
    ) {
    }

    public function getShopUrl(): string
    {
        /** @var string|null $shopUrl */
        $shopUrl = $this->shopConfig->getConfigParam('sShopURL');

        return (string)$shopUrl;
    }
}

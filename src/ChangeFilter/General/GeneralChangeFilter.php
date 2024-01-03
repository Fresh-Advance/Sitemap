<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\ChangeFilter\General;

use FreshAdvance\Sitemap\ChangeFilter\Shared\BaseChangeFilter;
use FreshAdvance\Sitemap\Integration\DataType\ObjectUrl;
use FreshAdvance\Sitemap\Settings\ShopSettingsInterface;

class GeneralChangeFilter extends BaseChangeFilter
{
    public function __construct(
        string $objectType,
        protected ShopSettingsInterface $shopSettings,
    ) {
        parent::__construct($objectType);
    }

    public function getUpdatedUrls(int $limit): \Generator
    {
        yield new ObjectUrl(
            objectId: "main",
            objectType: $this->getObjectType(),
            location: $this->prepareUrl('/'),
            modified: new \DateTime()
        );
    }

    protected function prepareUrl(string $url): string
    {
        return implode("/", [
            rtrim($this->shopSettings->getShopUrl()),
            $url
        ]);
    }
}

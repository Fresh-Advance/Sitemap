<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Url\DataTypeFactory;

use DateTime;
use FreshAdvance\Sitemap\Url\DataType\Url;
use FreshAdvance\Sitemap\Url\DataType\UrlInterface;

class UrlFactory implements UrlFactoryInterface
{
    public function __construct(
        private UrlTypeFactoryInterface $pageTypeConfigurationFactory
    ) {
    }

    public function createUrl(string $type, string $url, DateTime $modified): UrlInterface
    {
        $configuration = $this->pageTypeConfigurationFactory->getConfiguration($type);

        return new Url(
            $url,
            $modified,
            $configuration->getChangeFrequency(),
            $configuration->getPriority()
        );
    }
}

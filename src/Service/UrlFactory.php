<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\PageUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;
use FreshAdvance\Sitemap\PageType\PageTypeConfigurationFactoryInterface;

class UrlFactory implements UrlFactoryInterface
{
    public function __construct(
        private PageTypeConfigurationFactoryInterface $pageTypeConfigurationFactory
    ) {
    }

    public function createUrl(string $type, string $url, \DateTime $modified): PageUrlInterface
    {
        $configuration = $this->pageTypeConfigurationFactory->getConfiguration($type);

        return new PageUrl(
            $url,
            $modified,
            $configuration->getChangeFrequency(),
            $configuration->getPriority()
        );
    }
}

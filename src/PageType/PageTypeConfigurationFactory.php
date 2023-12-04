<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\PageType;

use FreshAdvance\Sitemap\Exception\PageTypeConfigurationFactorySetupException;

class PageTypeConfigurationFactory implements PageTypeConfigurationFactoryInterface
{
    protected array $configurations = [];

    /**
     * @param iterable<PageTypeConfigurationInterface> $configurations
     * @throws PageTypeConfigurationFactorySetupException
     */
    public function __construct(
        iterable $configurations,
        protected PageTypeConfigurationInterface $defaultConfiguration
    ) {
        foreach ($configurations as $oneConfiguration) {
            if (!$oneConfiguration instanceof PageTypeConfigurationInterface) {
                throw new PageTypeConfigurationFactorySetupException();
            }

            $this->configurations[$oneConfiguration->getObjectType()] = $oneConfiguration;
        }
    }

    public function getConfiguration(string $string): PageTypeConfigurationInterface
    {
        return $this->configurations[$string] ?? $this->defaultConfiguration;
    }
}

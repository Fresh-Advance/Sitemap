<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Url\DataTypeFactory;

use FreshAdvance\Sitemap\Url\DataType\UrlTypeInterface;
use FreshAdvance\Sitemap\Url\Exception\UrlTypeFactorySetupException;

class UrlTypeFactory implements UrlTypeFactoryInterface
{
    protected array $configurations = [];

    /**
     * @param iterable<UrlTypeInterface> $configurations
     * @throws \FreshAdvance\Sitemap\Url\Exception\UrlTypeFactorySetupException
     */
    public function __construct(
        iterable $configurations,
        protected UrlTypeInterface $defaultConfiguration
    ) {
        foreach ($configurations as $oneConfiguration) {
            if (!$oneConfiguration instanceof UrlTypeInterface) {
                throw new UrlTypeFactorySetupException();
            }

            $this->configurations[$oneConfiguration->getObjectType()] = $oneConfiguration;
        }
    }

    public function getConfiguration(string $string): UrlTypeInterface
    {
        return $this->configurations[$string] ?? $this->defaultConfiguration;
    }
}

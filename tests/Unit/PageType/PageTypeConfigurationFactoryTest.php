<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\PageType;

use FreshAdvance\Sitemap\Exception\PageTypeConfigurationFactorySetupException;
use FreshAdvance\Sitemap\PageType\PageTypeConfigurationFactory;
use FreshAdvance\Sitemap\PageType\PageTypeConfigurationInterface;
use PHPUnit\Framework\TestCase;

class PageTypeConfigurationFactoryTest extends TestCase
{
    public function testGetFilter(): void
    {
        $pageTypeConfigurationStub = $this->createMock(PageTypeConfigurationInterface::class);
        $pageTypeConfigurationStub->method('getObjectType')->willReturn('someObjectType');

        $sut = new PageTypeConfigurationFactory(
            configurations: [$pageTypeConfigurationStub],
            defaultConfiguration: $this->createStub(PageTypeConfigurationInterface::class)
        );

        $configuration = $sut->getConfiguration('someObjectType');
        $this->assertInstanceOf(PageTypeConfigurationInterface::class, $configuration);
    }

    public function testNotSupportedConfigurationGiven(): void
    {
        $this->expectException(PageTypeConfigurationFactorySetupException::class);

        new PageTypeConfigurationFactory(
            configurations: [new \stdClass()],
            defaultConfiguration: $this->createStub(PageTypeConfigurationInterface::class)
        );
    }

    public function testNotExistingConfigurationRequestGivesDefaultConfiguration(): void
    {
        $defaultConfiguration = $this->createStub(PageTypeConfigurationInterface::class);
        $sut = new PageTypeConfigurationFactory(
            configurations: [],
            defaultConfiguration: $defaultConfiguration,
        );

        $this->assertSame($defaultConfiguration, $sut->getConfiguration('unknown'));
    }
}

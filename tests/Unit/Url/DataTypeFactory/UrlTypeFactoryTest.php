<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Url\DataTypeFactory;

use FreshAdvance\Sitemap\Url\DataType\UrlTypeInterface;
use FreshAdvance\Sitemap\Url\DataTypeFactory\UrlTypeFactory;
use FreshAdvance\Sitemap\Url\Exception\UrlTypeFactorySetupException;
use PHPUnit\Framework\TestCase;
use stdClass;

class UrlTypeFactoryTest extends TestCase
{
    public function testGetFilter(): void
    {
        $pageTypeConfigurationStub = $this->createMock(
            UrlTypeInterface::class
        );
        $pageTypeConfigurationStub->method('getObjectType')->willReturn('someObjectType');

        $sut = new UrlTypeFactory(
            configurations: [$pageTypeConfigurationStub],
            defaultConfiguration: $this->createStub(
                UrlTypeInterface::class
            )
        );

        $configuration = $sut->getConfiguration('someObjectType');
        $this->assertInstanceOf(UrlTypeInterface::class, $configuration);
    }

    public function testNotSupportedConfigurationGiven(): void
    {
        $this->expectException(UrlTypeFactorySetupException::class);

        new UrlTypeFactory(
            configurations: [new stdClass()],
            defaultConfiguration: $this->createStub(
                UrlTypeInterface::class
            )
        );
    }

    public function testNotExistingConfigurationRequestGivesDefaultConfiguration(): void
    {
        $defaultConfiguration = $this->createStub(UrlTypeInterface::class);
        $sut = new UrlTypeFactory(
            configurations: [],
            defaultConfiguration: $defaultConfiguration,
        );

        $this->assertSame($defaultConfiguration, $sut->getConfiguration('unknown'));
    }
}

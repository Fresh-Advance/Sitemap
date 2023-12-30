<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Url\DataTypeFactory;

use DateTime;
use FreshAdvance\Sitemap\Url\DataType\UrlTypeInterface;
use FreshAdvance\Sitemap\Url\DataTypeFactory\UrlFactory;
use FreshAdvance\Sitemap\Url\DataTypeFactory\UrlTypeFactoryInterface;
use PHPUnit\Framework\TestCase;

class UrlFactoryTest extends TestCase
{
    public function testCreateUrl(): void
    {
        $sut = $this->getSut(
            ptConfigFactory: $ptConfFactory = $this->createMock(UrlTypeFactoryInterface::class)
        );

        $exampleType = uniqid();

        $ptConfigurationStub = $this->createMock(UrlTypeInterface::class);
        $ptConfigurationStub->method('getPriority')->willReturn($examplePriority = rand(1, 100) / 100);
        $ptConfigurationStub->method('getChangeFrequency')->willReturn($exampleFrequency = uniqid());

        $ptConfFactory->method('getConfiguration')->with($exampleType)->willReturn($ptConfigurationStub);

        $url = $sut->createUrl($exampleType, $exampleUrl = uniqid(), $modified = new DateTime());

        $this->assertSame($exampleUrl, $url->getLocation());
        $this->assertSame($modified, $url->getLastModified());
        $this->assertSame($examplePriority, $url->getPriority());
        $this->assertSame($exampleFrequency, $url->getChangeFrequency());
    }

    public function getSut(
        ?UrlTypeFactoryInterface $ptConfigFactory = null
    ): UrlFactory {
        return new UrlFactory(
            pageTypeConfigurationFactory: $ptConfigFactory ?? $this->createStub(UrlTypeFactoryInterface::class)
        );
    }
}

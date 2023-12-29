<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Service;

use FreshAdvance\Sitemap\PageType\PageTypeConfigurationFactoryInterface;
use FreshAdvance\Sitemap\PageType\PageTypeConfigurationInterface;
use FreshAdvance\Sitemap\Service\UrlFactory;
use PHPUnit\Framework\TestCase;

class UrlFactoryTest extends TestCase
{
    public function testCreateUrl(): void
    {
        $sut = $this->getSut(
            ptConfigFactory: $ptConfFactory = $this->createMock(PageTypeConfigurationFactoryInterface::class)
        );

        $exampleType = uniqid();

        $ptConfigurationStub = $this->createMock(PageTypeConfigurationInterface::class);
        $ptConfigurationStub->method('getPriority')->willReturn($examplePriority = rand(1, 100) / 100);
        $ptConfigurationStub->method('getChangeFrequency')->willReturn($exampleFrequency = uniqid());

        $ptConfFactory->method('getConfiguration')->with($exampleType)->willReturn($ptConfigurationStub);

        $url = $sut->createUrl($exampleType, $exampleUrl = uniqid(), $modified = new \DateTime());

        $this->assertSame($exampleUrl, $url->getLocation());
        $this->assertSame($modified, $url->getLastModified());
        $this->assertSame($examplePriority, $url->getPriority());
        $this->assertSame($exampleFrequency, $url->getChangeFrequency());
    }

    public function getSut(
        ?PageTypeConfigurationFactoryInterface $ptConfigFactory = null
    ): UrlFactory {
        return new UrlFactory(
            pageTypeConfigurationFactory: $ptConfigFactory ?? $this->createStub(PageTypeConfigurationFactoryInterface::class)
        );
    }
}

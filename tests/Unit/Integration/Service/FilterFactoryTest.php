<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Integration\Service;

use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;
use FreshAdvance\Sitemap\Integration\Exception\FilterConfigurationException;
use FreshAdvance\Sitemap\Integration\Exception\FilterNotFoundException;
use FreshAdvance\Sitemap\Integration\Service\FilterFactory;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \FreshAdvance\Sitemap\Integration\Service\FilterFactory
 */
class FilterFactoryTest extends TestCase
{
    public function testGetFilter(): void
    {
        $filterStub = $this->createMock(ChangeFilterInterface::class);
        $filterStub->method('getObjectType')->willReturn('someObjectType');

        $filters = [
            $filterStub
        ];

        $sut = new \FreshAdvance\Sitemap\Integration\Service\FilterFactory($filters);

        $filter = $sut->getFilter('someObjectType');
        $this->assertInstanceOf(ChangeFilterInterface::class, $filter);
    }

    public function testNotSupportedFilterGiven(): void
    {
        $this->expectException(FilterConfigurationException::class);

        new \FreshAdvance\Sitemap\Integration\Service\FilterFactory([
            new stdClass()
        ]);
    }

    public function testFilterNotFound(): void
    {
        $sut = new FilterFactory([]);

        $this->expectException(FilterNotFoundException::class);
        $sut->getFilter('unknown');
    }

    public function testGetFilters(): void
    {
        $filterStub1 = $this->createStub(ChangeFilterInterface::class);
        $filterStub1->method('getObjectType')->willReturn('filterStubType1');

        $filterStub2 = $this->createStub(ChangeFilterInterface::class);
        $filterStub2->method('getObjectType')->willReturn('filterStubType2');

        $filters = [
            $filterStub1,
            $filterStub2
        ];

        $sut = new \FreshAdvance\Sitemap\Integration\Service\FilterFactory($filters);

        $this->assertEquals($filters, array_values($sut->getFilters()));
    }
}

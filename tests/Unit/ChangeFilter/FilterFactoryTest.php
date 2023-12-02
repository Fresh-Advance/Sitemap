<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace ChangeFilter;

use FreshAdvance\Sitemap\ChangeFilter\ChangeFilterInterface;
use FreshAdvance\Sitemap\ChangeFilter\FilterFactory;
use FreshAdvance\Sitemap\Exception\FilterConfigurationException;
use FreshAdvance\Sitemap\Exception\FilterNotFoundException;

/**
 * @covers \FreshAdvance\Sitemap\ChangeFilter\FilterFactory
 */
class FilterFactoryTest extends \PHPUnit\Framework\TestCase
{
    public function testGetFilter(): void
    {
        $filterStub = $this->createMock(ChangeFilterInterface::class);
        $filterStub->method('getObjectType')->willReturn('someObjectType');

        $filters = [
            $filterStub
        ];

        $sut = new FilterFactory($filters);

        $filter = $sut->getFilter('someObjectType');
        $this->assertInstanceOf(ChangeFilterInterface::class, $filter);
    }

    public function testNotSupportedFilterGiven(): void
    {
        $this->expectException(FilterConfigurationException::class);

        new FilterFactory([
            new \stdClass()
        ]);
    }

    public function testFilterNotFound(): void
    {
        $sut = new FilterFactory([]);

        $this->expectException(FilterNotFoundException::class);
        $sut->getFilter('unknown');
    }
}

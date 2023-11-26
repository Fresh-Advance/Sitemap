<?php

namespace ChangeFilter;

use FreshAdvance\Sitemap\ChangeFilter\ChangeFilterInterface;
use FreshAdvance\Sitemap\ChangeFilter\FilterService;
use FreshAdvance\Sitemap\Exception\FilterConfigurationException;
use FreshAdvance\Sitemap\Exception\FilterNotFoundException;

/**
 * @covers FilterService
 */
class FilterServiceTest extends \PHPUnit\Framework\TestCase
{
    public function testGetFilter(): void
    {
        $filterStub = $this->createMock(ChangeFilterInterface::class);
        $filterStub->method('getObjectType')->willReturn('someObjectType');

        $filters = [
            $filterStub
        ];

        $sut = new FilterService($filters);

        $filter = $sut->getFilter('someObjectType');
        $this->assertInstanceOf(ChangeFilterInterface::class, $filter);
    }

    public function testNotSupportedFilterGiven(): void
    {
        $this->expectException(FilterConfigurationException::class);

        new FilterService([
            new \stdClass()
        ]);
    }

    public function testFilterNotFound(): void
    {
        $sut = new FilterService([]);

        $this->expectException(FilterNotFoundException::class);
        $sut->getFilter('unknown');
    }
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Integration\Service;

use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;
use FreshAdvance\Sitemap\Integration\DataType\ObjectUrlInterface;
use FreshAdvance\Sitemap\Integration\Service\FilterFactoryInterface;
use FreshAdvance\Sitemap\Url\Repository\UrlRepositoryInterface;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Sitemap\Integration\Service\Synchronizer
 */
class SynchronizerTest extends TestCase
{
    public function testUpdateIteratesOverUrlsAndUpdatesThemThroughRepository(): void
    {
        $filterStub = $this->createMock(ChangeFilterInterface::class);
        $filterStub->method('getUpdatedUrls')->willReturn(
            $this->arrayAsGenerator([
                $objectUrlStub1 = $this->createStub(ObjectUrlInterface::class),
                $objectUrlStub2 = $this->createStub(ObjectUrlInterface::class)
            ])
        );

        $filterServiceStub = $this->createMock(FilterFactoryInterface::class);
        $filterServiceStub->method('getFilter')->with('someType')->willReturn($filterStub);

        $urlRepository = $this->createMock(UrlRepositoryInterface::class);
        $matcher = $this->exactly(2);
        $urlRepository->expects($matcher)
            ->method('addObjectUrl')
            ->willReturnCallback(
                function (
                    ObjectUrlInterface $objectUrl
                ) use (
                    $matcher,
                    $objectUrlStub1,
                    $objectUrlStub2
                ) {
                    switch ($matcher->getInvocationCount()) {
                        case "1":
                            $this->assertEquals($objectUrlStub1, $objectUrl);
                            break;
                        case "2":
                            $this->assertEquals($objectUrlStub2, $objectUrl);
                            break;
                        default:
                            $this->fail("Fail");
                    }
                }
            );

        $sut = new \FreshAdvance\Sitemap\Integration\Service\Synchronizer(
            filterService: $filterServiceStub,
            urlRepository: $urlRepository,
        );

        $this->assertSame(2, $sut->updateTypeUrls('someType'));
    }

    protected function arrayAsGenerator(array $array): Generator
    {
        foreach ($array as $key => $item) {
            yield $key => $item;
        }
    }
}

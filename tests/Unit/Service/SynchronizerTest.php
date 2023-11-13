<?php

namespace FreshAdvance\Sitemap\Tests\Unit\Service;

use FreshAdvance\Sitemap\ChangeFilter\ChangeFilterInterface;
use FreshAdvance\Sitemap\DataStructure\ObjectUrlInterface;
use FreshAdvance\Sitemap\DataStructure\UrlInterface;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use FreshAdvance\Sitemap\ChangeFilter\FilterServiceInterface;
use FreshAdvance\Sitemap\Service\Synchronizer;

class SynchronizerTest extends \PHPUnit\Framework\TestCase
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

        $filterServiceStub = $this->createMock(FilterServiceInterface::class);
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

        $sut = new Synchronizer(
            filterService: $filterServiceStub,
            urlRepository: $urlRepository,
        );

        $this->assertSame(2, $sut->updateTypeUrls('someType'));
    }

    protected function arrayAsGenerator(array $array): \Generator
    {
        foreach ($array as $key => $item) {
            yield $key => $item;
        }
    }
}

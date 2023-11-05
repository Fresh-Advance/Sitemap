<?php

namespace FreshAdvance\Sitemap\Tests\Unit\Service;

use FreshAdvance\Sitemap\ChangeFilter\ChangeFilterInterface;
use FreshAdvance\Sitemap\DataStructure\UrlInterface;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use FreshAdvance\Sitemap\Service\FilterServiceInterface;
use FreshAdvance\Sitemap\Service\Synchronizer;

class SynchronizerTest extends \PHPUnit\Framework\TestCase
{
    public function testUpdateIteratesOverUrlsAndUpdatesThemThroughRepository(): void
    {
        $filterStub = $this->createMock(ChangeFilterInterface::class);
        $filterStub->method('getUpdatedUrls')->willReturn(
            $this->arrayAsGenerator([
                'urlKey1' => $urlStub1 = $this->createStub(UrlInterface::class),
                'urlKey2' => $urlStub2 = $this->createStub(UrlInterface::class)
            ])
        );

        $filterServiceStub = $this->createMock(FilterServiceInterface::class);
        $filterServiceStub->method('getFilter')->with('someType')->willReturn($filterStub);

        $urlRepository = $this->createMock(UrlRepositoryInterface::class);
        $matcher = $this->exactly(2);
        $urlRepository->expects($matcher)
            ->method('addUrl')
            ->willReturnCallback(
                function (
                    string $objectId,
                    string $objectType,
                    UrlInterface $url
                ) use (
                    $matcher,
                    $urlStub1,
                    $urlStub2
                ) {
                    $this->assertEquals('someType', $objectType);
                    switch ($matcher->getInvocationCount()) {
                        case "1":
                            $this->assertEquals('urlKey1', $objectId);
                            $this->assertEquals($urlStub1, $url);
                            break;
                        case "2":
                            $this->assertEquals('urlKey2', $objectId);
                            $this->assertEquals($urlStub2, $url);
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

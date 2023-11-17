<?php

namespace FreshAdvance\Sitemap\Tests\Integration\Repository;

use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;
use FreshAdvance\Sitemap\Repository\UrlRepository;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;

/**
 * @covers \FreshAdvance\Sitemap\Repository\UrlRepository
 */
class UrlRepositoryTest extends IntegrationTestCase
{
    public function testSaveAndThenGetUrl(): void
    {
        $sut = $this->getSut();

        $objectId = 'exampleObjectId';
        $objectType = 'exampleObjectType';
        $url = new PageUrl(
            location: 'someLocation',
            lastModified: '2020-03-04 01:02:03',
            changeFrequency: 'frequency',
            priority: 0.3
        );

        $sut->addObjectUrl(
            new ObjectUrl(
                objectId: $objectId,
                objectType: $objectType,
                url: $url,
            )
        );

        $url = $sut->getUrl($objectId, $objectType);

        $this->assertSame('someLocation', $url->getLocation());
        $this->assertSame('2020-03-04 01:02:03', $url->getLastModified());
        $this->assertSame('frequency', $url->getChangeFrequency());
        $this->assertSame(0.3, $url->getPriority());
    }

    public function testNotFoundUrl(): void
    {
        $sut = $this->getSut();
        $this->assertNull($sut->getUrl('someObjectId', 'someObjectType'));
    }

    public function testGetUrlsByType(): void
    {
        $sut = $this->getSut();
        $objectType = 'someType';

        for ($i = 1; $i <= 10; $i++) {
            $sut->addObjectUrl(
                new ObjectUrl(
                    objectId: 'exampleObject' . $i,
                    objectType: $objectType,
                    url: new PageUrl(
                        location: 'someLocation' . $i,
                        lastModified: 'modifiedDate',
                        changeFrequency: 'frequency',
                        priority: 0.3
                    )
                )
            );
        }

        $startId = 4;
        $count = 0;
        /** @var PageUrlInterface $oneUrlItem */
        foreach ($sut->getUrlsByType($objectType, 2, 3) as $oneUrlItem) {
            $this->assertInstanceOf(PageUrlInterface::class, $oneUrlItem);
            $this->assertSame('someLocation' . $startId, $oneUrlItem->getLocation());

            $count++;
            $startId++;
        }

        $this->assertSame(3, $count);

        $this->assertSame(10, $sut->getUrlsCount());
    }

    protected function getSut(): UrlRepository
    {
        return $this->get(UrlRepositoryInterface::class);
    }
}

<?php

namespace FreshAdvance\Sitemap\Tests\Integration\Repository;

use FreshAdvance\Sitemap\DataStructure\Url;
use FreshAdvance\Sitemap\DataStructure\UrlInterface;
use FreshAdvance\Sitemap\Repository\UrlRepository;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;

class UrlRepositoryTest extends IntegrationTestCase
{
    public function testSaveAndThenGetUrl(): void
    {
        $sut = $this->getSut();

        $objectId = 'exampleObjectId';
        $objectType = 'exampleObjectType';

        $sut->addUrl(
            $objectId,
            $objectType,
            new Url(
                location: 'someLocation',
                lastModified: 'modifiedDate',
                changeFrequency: 'frequency',
                priority: 0.3
            )
        );

        $url = $sut->getUrl($objectId, $objectType);

        $this->assertSame('someLocation', $url->getLocation());
        $this->assertSame('modifiedDate', $url->getLastModified());
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
            $sut->addUrl(
                'exampleObject' . $i,
                $objectType,
                new Url(
                    location: 'someLocation' . $i,
                    lastModified: 'modifiedDate',
                    changeFrequency: 'frequency',
                    priority: 0.3
                )
            );
        }

        $startId = 4;
        $count = 0;
        /** @var UrlInterface $oneUrlItem */
        foreach ($sut->getUrlsByType($objectType, 2, 3) as $oneUrlItem) {
            $this->assertSame('someLocation' . ($startId++), $oneUrlItem->getLocation());
            $count++;
        }

        $this->assertSame(3, $count);
    }

    protected function getSut(): UrlRepository
    {
        return $this->get(UrlRepositoryInterface::class);
    }
}

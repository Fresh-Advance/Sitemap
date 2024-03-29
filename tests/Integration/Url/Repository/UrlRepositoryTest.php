<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\Url\Repository;

use DateTime;
use FreshAdvance\Sitemap\Integration\DataType\ObjectUrl;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use FreshAdvance\Sitemap\Url\DataType\UrlInterface;
use FreshAdvance\Sitemap\Url\Repository\UrlRepository;
use FreshAdvance\Sitemap\Url\Repository\UrlRepositoryInterface;

/**
 * @covers \FreshAdvance\Sitemap\Url\Repository\UrlRepository
 */
class UrlRepositoryTest extends IntegrationTestCase
{
    public function testSaveAndThenGetUrl(): void
    {
        $sut = $this->getSut();

        $objectId = 'exampleObjectId';
        $objectType = 'exampleObjectType';

        $sut->addObjectUrl(
            new ObjectUrl(
                objectId: $objectId,
                objectType: $objectType,
                location: 'someLocation',
                modified: new DateTime('2020-03-04 01:02:03')
            )
        );

        $url = $sut->getUrl($objectId, $objectType);

        $this->assertSame('someLocation', $url->getLocation());
        $this->assertEquals(new DateTime('2020-03-04 01:02:03'), $url->getLastModified());
    }

    public function testNotFoundUrl(): void
    {
        $sut = $this->getSut();
        $this->assertNull($sut->getUrl('someObjectId', 'someObjectType'));
    }

    public function testGetUrlsByTypeAndUrlsCounter(): void
    {
        $connection = $this->getConnection();
        $connection->executeQuery("delete from fa_sitemap");

        $sut = $this->getSut();
        for ($i = 1; $i <= 10; $i++) {
            $sut->addObjectUrl(
                new ObjectUrl(
                    objectId: 'exampleObject' . $i,
                    objectType: 'someType',
                    location: 'someLocation' . $i,
                    modified: new DateTime()
                )
            );
        }

        $startId = 4;
        $count = 0;
        /** @var UrlInterface $oneUrlItem */
        foreach ($sut->getUrls(2, 3) as $oneUrlItem) {
            $this->assertInstanceOf(UrlInterface::class, $oneUrlItem);
            $this->assertSame('someLocation' . $startId, $oneUrlItem->getLocation());

            $count++;
            $startId++;
        }

        $this->assertSame(3, $count);

        $this->assertSame(10, $sut->getUrlsCount());
    }

    public function testDeleteByIds(): void
    {
        $connection = $this->getConnection();
        $connection->executeQuery("delete from fa_sitemap");
        $connection->executeQuery(
            "insert into fa_sitemap (id, object_id, location, object_type) values
            (998, 'firstobject', 'somelocation1', '{$this->objectType}'),
            (999, 'secondobject', 'somelocation2', '{$this->objectType}'),
            (1000, 'thirdobject', 'somelocation3', '{$this->objectType}'),
            (1001, 'fourthobject', 'somelocation4', 'not content')"
        );

        $ids = [999, 1000];

        $sut = $this->getSut();
        $sut->deleteByIds($ids);

        $idsLeft = $connection->executeQuery("select id from fa_sitemap")->fetchFirstColumn();
        $this->assertEquals([998, 1001], $idsLeft);
    }

    protected function getSut(): UrlRepository
    {
        return $this->get(UrlRepositoryInterface::class);
    }
}

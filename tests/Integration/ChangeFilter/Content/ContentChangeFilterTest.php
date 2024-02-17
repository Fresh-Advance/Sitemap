<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\ChangeFilter\Content;

use DateTime;
use FreshAdvance\Sitemap\ChangeFilter\Content\ContentChangeFilter;
use FreshAdvance\Sitemap\Integration\DataType\ObjectUrlInterface;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use OxidEsales\EshopCommunity\Application\Model\Content;

/**
 * @covers \FreshAdvance\Sitemap\ChangeFilter\Shared\DatabaseChangeFilter
 * @covers \FreshAdvance\Sitemap\ChangeFilter\Content\ContentChangeFilter
 */
class ContentChangeFilterTest extends IntegrationTestCase
{
    protected string $objectType = 'content';

    public function testCheckCurrentUrlItem(): void
    {
        $connection = $this->getConnection();
        $connection->executeQuery("update oxcontents set oxtimestamp='2023-09-01'");

        $this->addConcreteDateUrl($this->objectType, new DateTime("2023-10-01"));

        $this->createExampleContent('example1', true, 'CMSFOLDER_USERINFO');
        $this->createExampleContent('example2', true, 'OTHER');
        $this->createExampleContent('example3', true, '');
        $this->createExampleContent('example4', false, 'CMSFOLDER_USERINFO');
        $this->createExampleContent('example5', true, 'CMSFOLDER_USERINFO');

        $sut = $this->getSut();
        $urls = $sut->getUpdatedUrls(3);

        $this->checkCurrentUrlItem($urls->current(), 'example1');

        $urls->next();
        $this->checkCurrentUrlItem($urls->current(), 'example5');

        $urls->next();
        $this->assertNull($urls->current());
    }

    protected function createExampleContent(string $identifier, bool $active, string $folder): void
    {
        $content = oxNew(Content::class);
        $content->assign([
            'oxid' => $identifier,
            'oxactive' => $active,
            'oxtitle' => $identifier,
            'oxloadid' => $identifier,
            'oxfolder' => $folder
        ]);
        $content->save();
    }

    protected function checkCurrentUrlItem(ObjectUrlInterface $objectUrl, string $value): void
    {
        $this->assertSame('content', $objectUrl->getObjectType());

        $this->assertSame('http://localhost.local/' . $value . '/', $objectUrl->getLocation());
        $this->assertNotEmpty($objectUrl->getModified());
    }

    public function testGetDisabledUrls(): void
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

        $sut = $this->getSut();
        $expectedIds = [998, 999, 1000];
        $this->assertSame($expectedIds, $sut->getDisabledUrlIds());
    }

    public function getSut(): ContentChangeFilter
    {
        return $this->get(ContentChangeFilter::class);
    }
}

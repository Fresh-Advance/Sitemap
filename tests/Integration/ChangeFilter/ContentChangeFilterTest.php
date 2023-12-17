<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\ChangeFilter;

use FreshAdvance\Sitemap\ChangeFilter\ContentChangeFilter;
use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\ObjectUrlInterface;
use FreshAdvance\Sitemap\DataStructure\PageUrl;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use OxidEsales\EshopCommunity\Application\Model\Content;

/**
 * @covers \FreshAdvance\Sitemap\ChangeFilter\ChangeFilterTemplate
 * @covers \FreshAdvance\Sitemap\ChangeFilter\ContentChangeFilter
 */
class ContentChangeFilterTest extends IntegrationTestCase
{
    public function testCheckCurrentUrlItem(): void
    {
        $connection = $this->getConnection();
        $connection->executeQuery("update oxcontents set oxtimestamp='2023-09-01'");

        $this->addConcreteDateUrl('content', new \DateTime("2023-10-01"));

        $this->createExampleContent('example1', true, 'CMSFOLDER_USERINFO');
        $this->createExampleContent('example2', true, 'OTHER');
        $this->createExampleContent('example3', true, '');
        $this->createExampleContent('example4', false, 'CMSFOLDER_USERINFO');
        $this->createExampleContent('example5', true, 'CMSFOLDER_USERINFO');

        /** @var ContentChangeFilter $sut */
        $sut = $this->get(ContentChangeFilter::class);
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
}

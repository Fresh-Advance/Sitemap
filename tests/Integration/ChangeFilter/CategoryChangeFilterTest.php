<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\ChangeFilter;

use FreshAdvance\Sitemap\ChangeFilter\CategoryChangeFilter;
use FreshAdvance\Sitemap\DataStructure\ObjectUrlInterface;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use OxidEsales\Eshop\Application\Model\Category;

class CategoryChangeFilterTest extends IntegrationTestCase
{
    public function testGetUpdatedUrls(): void
    {
        $connection = $this->getConnection();
        $connection->executeQuery("update oxcategories set oxtimestamp='2023-09-01'");

        $this->addConcreteDateUrl('category', new \DateTime("2023-10-01"));

        $this->createExampleCategory('example1', true);
        $this->createExampleCategory('example2', false);
        $this->createExampleCategory('example3', true);

        /** @var CategoryChangeFilter $sut */
        $sut = $this->get(CategoryChangeFilter::class);
        $urls = $sut->getUpdatedUrls(3);

        $this->checkCurrentUrlItem($urls->current(), 'example1');

        $urls->next();
        $this->checkCurrentUrlItem($urls->current(), 'example3');

        $urls->next();
        $this->assertNull($urls->current());

        $this->assertTrue(true);
    }

    protected function createExampleCategory(string $identifier, bool $active): void
    {
        $category = oxNew(Category::class);
        $category->assign([
            'oxid' => $identifier,
            'oxactive' => $active,
            'oxtitle' => $identifier,
            'oxparentid' => 'oxrootid',
        ]);
        $category->save();
    }

    protected function checkCurrentUrlItem(ObjectUrlInterface $objectUrl, string $value): void
    {
        $this->assertSame('category', $objectUrl->getObjectType());

        $url = $objectUrl->getUrl();
        $this->assertSame('http://localhost.local/' . $value . '/', $url->getLocation());
        $this->assertNotEmpty($url->getLastModified());
        $this->assertSame('daily', $url->getChangeFrequency());
        $this->assertSame(0.9, $url->getPriority());
    }
}

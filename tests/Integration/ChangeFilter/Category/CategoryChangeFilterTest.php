<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\ChangeFilter\Category;

use DateTime;
use FreshAdvance\Sitemap\ChangeFilter\Category\CategoryChangeFilter;
use FreshAdvance\Sitemap\Integration\DataType\ObjectUrlInterface;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use OxidEsales\Eshop\Application\Model\Category;

/**
 * @covers \FreshAdvance\Sitemap\ChangeFilter\Shared\DatabaseChangeFilter
 * @covers \FreshAdvance\Sitemap\ChangeFilter\Category\CategoryChangeFilter
 */
class CategoryChangeFilterTest extends IntegrationTestCase
{
    public function testGetUpdatedUrls(): void
    {
        $connection = $this->getConnection();
        $connection->executeQuery("update oxcategories set oxtimestamp='2023-09-01'");

        $this->addConcreteDateUrl('category', new DateTime("2023-10-01"));

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

        $this->assertSame('http://localhost.local/' . $value . '/', $objectUrl->getLocation());
        $this->assertNotEmpty($objectUrl->getModified());
    }
}

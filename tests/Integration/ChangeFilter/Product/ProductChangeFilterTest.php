<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\ChangeFilter\Product;

use DateTime;
use FreshAdvance\Sitemap\ChangeFilter\Product\ProductChangeFilter;
use FreshAdvance\Sitemap\Integration\DataType\ObjectUrlInterface;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use OxidEsales\Eshop\Application\Model\Article;

/**
 * @covers \FreshAdvance\Sitemap\ChangeFilter\Shared\DatabaseChangeFilter
 * @covers \FreshAdvance\Sitemap\ChangeFilter\Product\ProductChangeFilter
 */
class ProductChangeFilterTest extends IntegrationTestCase
{
    protected string $objectType = 'product';

    public function testGetUpdatedUrls()
    {
        $connection = $this->getConnection();
        $connection->executeQuery("update oxarticles set oxtimestamp='2023-09-01'");

        $this->addConcreteDateUrl($this->objectType, new DateTime("2023-10-01"));

        $this->createExampleProduct('example1', true);
        $this->createExampleProduct('example2', false);
        $this->createExampleProduct('example3', true);

        $sut = $this->getSut();
        $urls = $sut->getUpdatedUrls(3);

        $this->checkCurrentUrlItem($urls->current(), 'example1');

        $urls->next();
        $this->checkCurrentUrlItem($urls->current(), 'example3');

        $urls->next();
        $this->assertNull($urls->current());

        $this->assertTrue(true);
    }

    protected function createExampleProduct(string $identifier, bool $active): void
    {
        $product = oxNew(Article::class);
        $product->assign([
            'oxid' => $identifier,
            'oxactive' => $active,
            'oxtitle' => $identifier,
        ]);
        $product->save();
    }

    protected function checkCurrentUrlItem(ObjectUrlInterface $objectUrl, string $value): void
    {
        $this->assertSame($this->objectType, $objectUrl->getObjectType());

        $this->assertSame('http://localhost.local/' . $value . '.html', $objectUrl->getLocation());
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
        $this->assertEquals($expectedIds, $sut->getDisabledUrlIds());
    }

    public function getSut(): ProductChangeFilter
    {
        return $this->get(ProductChangeFilter::class);
    }
}

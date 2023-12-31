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
 * @covers \FreshAdvance\Sitemap\ChangeFilter\Shared\ChangeFilterTemplate
 * @covers \FreshAdvance\Sitemap\ChangeFilter\Product\ProductChangeFilter
 */
class ProductChangeFilterTest extends IntegrationTestCase
{
    public function testSomething()
    {
        $connection = $this->getConnection();
        $connection->executeQuery("update oxarticles set oxtimestamp='2023-09-01'");

        $this->addConcreteDateUrl('product', new DateTime("2023-10-01"));

        $this->createExampleProduct('example1', true);
        $this->createExampleProduct('example2', false);
        $this->createExampleProduct('example3', true);

        /** @var ProductChangeFilter $sut */
        $sut = $this->get(ProductChangeFilter::class);
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
        $this->assertSame('product', $objectUrl->getObjectType());

        $this->assertSame('http://localhost.local/' . $value . '.html', $objectUrl->getLocation());
        $this->assertNotEmpty($objectUrl->getModified());
    }
}

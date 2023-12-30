<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\Repository;

use FreshAdvance\Sitemap\Integration\Exception\ModelItemNotFoundException;
use FreshAdvance\Sitemap\Repository\ModelItemRepository;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use Generator;
use OxidEsales\Eshop\Application\Model\Article;
use OxidEsales\Eshop\Application\Model\Category;
use OxidEsales\Eshop\Application\Model\Content;

class ModelItemRepositoryTest extends IntegrationTestCase
{
    /** @dataProvider getItemDataProvider */
    public function testGetItem(string $model, string $filler): void
    {
        $identifier = uniqid();
        $this->$filler($identifier);

        $sut = new ModelItemRepository(model: $model);
        $item = $sut->getItem($identifier);

        $this->assertTrue($item->isLoaded());
    }

    public function getItemDataProvider(): Generator
    {
        yield [
            'model' => Content::class,
            'filler' => 'createExampleContent'
        ];

        yield [
            'model' => Article::class,
            'filler' => 'createExampleProduct'
        ];

        yield [
            'model' => Category::class,
            'filler' => 'createExampleCategory'
        ];
    }

    public function testLoadingFailureThrowsException(): void
    {
        $sut = new ModelItemRepository(model: Content::class);

        $this->expectException(ModelItemNotFoundException::class);
        $sut->getItem(uniqid());
    }

    protected function createExampleContent(string $identifier): void
    {
        $content = oxNew(Content::class);
        $content->assign([
            'oxid' => $identifier,
            'oxtitle' => $identifier,
            'oxloadid' => $identifier
        ]);
        $content->save();
    }

    protected function createExampleProduct(string $identifier): void
    {
        $product = oxNew(Article::class);
        $product->assign([
            'oxid' => $identifier,
            'oxtitle' => $identifier,
        ]);
        $product->save();
    }

    protected function createExampleCategory(string $identifier): void
    {
        $category = oxNew(Category::class);
        $category->assign([
            'oxid' => $identifier,
            'oxtitle' => $identifier,
            'oxparentid' => 'oxrootid',
        ]);
        $category->save();
    }
}

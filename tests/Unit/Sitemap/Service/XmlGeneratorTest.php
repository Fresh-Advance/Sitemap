<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Sitemap\Service;

use DateTime;
use DateTimeInterface;
use FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrlInterface;
use FreshAdvance\Sitemap\Sitemap\Service\XmlGenerator;
use FreshAdvance\Sitemap\Url\DataType\UrlInterface;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Sitemap\Sitemap\Service\XmlGenerator
 */
class XmlGeneratorTest extends TestCase
{
    public function testGenerateUrlItem(): void
    {
        $urlStub = $this->createConfiguredMock(UrlInterface::class, [
            'getLocation' => 'someLocation',
            'getLastModified' => $exampleDate = new DateTime(),
            'getChangeFrequency' => 'someFrequency',
            'getPriority' => 0.6,
        ]);

        $expectation = implode("", [
            "<url>",
            "<loc>someLocation</loc>",
            "<lastmod>{$exampleDate->format(DateTimeInterface::ATOM)}</lastmod>",
            "<changefreq>someFrequency</changefreq>",
            "<priority>0.6</priority>",
            "</url>",
        ]);

        $sut = $this->createPartialMock(XmlGenerator::class, []);
        $this->assertSame($expectation, $sut->generateUrlItem($urlStub));
    }

    public function testGenerateSitemapItem(): void
    {
        $urlStub = $this->createConfiguredMock(SitemapUrlInterface::class, [
            'getLocation' => 'someLocation',
            'getLastModified' => $exampleDate = new DateTime()
        ]);

        $expectation = implode("", [
            "<sitemap>",
            "<loc>someLocation</loc>",
            "<lastmod>{$exampleDate->format(DateTimeInterface::ATOM)}</lastmod>",
            "</sitemap>",
        ]);

        $sut = $this->createPartialMock(XmlGenerator::class, []);
        $this->assertSame($expectation, $sut->generateSitemapItem($urlStub));
    }

    public function testGenerateSitemapContent(): void
    {
        $urlStub = $this->createStub(UrlInterface::class);

        $sut = $this->createPartialMock(XmlGenerator::class, ['generateUrlItem']);
        $sut->expects($this->exactly(3))
            ->method('generateUrlItem')
            ->with($urlStub)
            ->willReturn("ItemContent");

        $expectation = implode("", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">',
            'ItemContent',
            'ItemContent',
            'ItemContent',
            '</urlset>'
        ]);

        $items = [
            $urlStub,
            $urlStub,
            $urlStub,
        ];

        $this->assertSame($expectation, $sut->generateSitemapDocument($items));
    }

    public function testGenerateSitemapIndexContent(): void
    {
        $sitemapUrl = $this->createStub(SitemapUrlInterface::class);

        $sut = $this->createPartialMock(XmlGenerator::class, ['generateSitemapItem']);
        $sut->expects($this->exactly(3))
            ->method('generateSitemapItem')
            ->with($sitemapUrl)
            ->willReturn("SitemapItemContent");

        $expectation = implode("", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<sitemapindex xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">',
            'SitemapItemContent',
            'SitemapItemContent',
            'SitemapItemContent',
            '</sitemapindex>'
        ]);

        $items = [
            $sitemapUrl,
            $sitemapUrl,
            $sitemapUrl,
        ];

        $this->assertSame($expectation, $sut->generateSitemapIndexDocument($items));
    }
}

<?php

namespace FreshAdvance\Sitemap\Tests\Unit\Service;

use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;
use FreshAdvance\Sitemap\DataStructure\SitemapUrlInterface;
use FreshAdvance\Sitemap\Service\XmlGenerator;

/**
 * @covers \FreshAdvance\Sitemap\Service\XmlGenerator
 */
class XmlGeneratorTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerateUrlItem(): void
    {
        $urlStub = $this->createConfiguredMock(PageUrlInterface::class, [
            'getLocation' => 'someLocation',
            'getLastModified' => 'lastModifiedDate',
            'getChangeFrequency' => 'someFrequency',
            'getPriority' => 0.6,
        ]);

        $expectation = implode("", [
            "<url>",
            "<loc>someLocation</loc>",
            "<lastmod>lastModifiedDate</lastmod>",
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
            'getLastModified' => 'lastModifiedDate'
        ]);

        $expectation = implode("", [
            "<sitemap>",
            "<loc>someLocation</loc>",
            "<lastmod>lastModifiedDate</lastmod>",
            "</sitemap>",
        ]);

        $sut = $this->createPartialMock(XmlGenerator::class, []);
        $this->assertSame($expectation, $sut->generateSitemapItem($urlStub));
    }

    public function testGenerateSitemapContent(): void
    {
        $urlStub = $this->createStub(PageUrlInterface::class);

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

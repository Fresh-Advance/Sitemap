<?php

namespace FreshAdvance\Sitemap\Tests\Unit\Service;

use FreshAdvance\Sitemap\DataStructure\UrlInterface;
use FreshAdvance\Sitemap\Service\XmlGenerator;

class XmlGeneratorTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerateUrlItem(): void
    {
        $urlStub = $this->createConfiguredMock(UrlInterface::class, [
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

    public function testGenerateSitemapContent(): void
    {
        $sut = $this->createPartialMock(XmlGenerator::class, ['generateUrlItem']);
        $sut->expects($this->exactly(3))->method('generateUrlItem')->willReturn("ItemContent");

        $expectation = implode("", [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">',
            'ItemContent',
            'ItemContent',
            'ItemContent',
            '</urlset>'
        ]);

        $items = [
            $this->createStub(UrlInterface::class),
            $this->createStub(UrlInterface::class),
            $this->createStub(UrlInterface::class),
        ];

        $this->assertSame($expectation, $sut->generateSitemapDocument($items));
    }
}

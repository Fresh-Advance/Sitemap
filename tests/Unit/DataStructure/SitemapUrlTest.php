<?php

namespace DataStructure;

use FreshAdvance\Sitemap\DataStructure\SitemapUrl;

/**
 * @covers \FreshAdvance\Sitemap\DataStructure\SitemapUrl
 */
class SitemapUrlTest extends \PHPUnit\Framework\TestCase
{
    public function testMainGetters(): void
    {
        $locationExample = 'someLoc';
        $lastModifiedExample = new \DateTime();

        $sut = new SitemapUrl(
            location: $locationExample,
            lastModified: $lastModifiedExample,
        );

        $this->assertSame($locationExample, $sut->getLocation());
        $this->assertSame($lastModifiedExample, $sut->getLastModified());
    }
}

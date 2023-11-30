<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

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

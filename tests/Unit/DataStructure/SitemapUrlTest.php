<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace DataStructure;

use DateTime;
use FreshAdvance\Sitemap\DataStructure\SitemapUrl;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Sitemap\DataStructure\SitemapUrl
 */
class SitemapUrlTest extends TestCase
{
    public function testMainGetters(): void
    {
        $locationExample = 'someLoc';
        $lastModifiedExample = new DateTime();

        $sut = new SitemapUrl(
            location: $locationExample,
            lastModified: $lastModifiedExample,
        );

        $this->assertSame($locationExample, $sut->getLocation());
        $this->assertSame($lastModifiedExample, $sut->getLastModified());
    }
}

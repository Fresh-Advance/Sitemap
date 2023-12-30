<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Sitemap\DataType;

use DateTime;
use FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrl;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Sitemap\Sitemap\DataType\SitemapUrl
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

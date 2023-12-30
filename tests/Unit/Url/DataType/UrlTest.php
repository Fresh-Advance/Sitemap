<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Url\DataType;

use DateTime;
use FreshAdvance\Sitemap\Url\DataType\Url;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Sitemap\Url\DataType\Url
 */
class UrlTest extends TestCase
{
    public function testMainGetters(): void
    {
        $locationExample = 'someLoc';
        $lastModifiedExample = new DateTime();
        $changeFrequencyExample = 'someChangeFrequency';
        $examplePriority = 0.5;

        $sut = new Url(
            location: $locationExample,
            lastModified: $lastModifiedExample,
            changeFrequency: $changeFrequencyExample,
            priority: $examplePriority
        );

        $this->assertSame($locationExample, $sut->getLocation());
        $this->assertSame($lastModifiedExample, $sut->getLastModified());
        $this->assertSame($changeFrequencyExample, $sut->getChangeFrequency());
        $this->assertSame($examplePriority, $sut->getPriority());
    }
}

<?php

namespace FreshAdvance\Sitemap\Tests\Unit\DataStructure;

use FreshAdvance\Sitemap\DataStructure\Url;

class UrlTest extends \PHPUnit\Framework\TestCase
{
    public function testMainGetters(): void
    {
        $locationExample = 'someLoc';
        $lastModifiedExample = 'someStringDate';
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

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Url\DataType;

use FreshAdvance\Sitemap\Url\DataType\UrlType;
use PHPUnit\Framework\TestCase;

class UrlTypeTest extends TestCase
{
    public function testGetters(): void
    {
        $objectType = 'someObjectType';
        $changeFrequency = 'daily';
        $priority = 0.35;

        $sut = new UrlType(
            objectType: $objectType,
            changeFrequency: $changeFrequency,
            priority: $priority,
        );

        $this->assertSame($objectType, $sut->getObjectType());
        $this->assertSame($changeFrequency, $sut->getChangeFrequency());
        $this->assertSame($priority, $sut->getPriority());
    }
}

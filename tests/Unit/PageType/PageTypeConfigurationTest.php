<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\PageType;

use FreshAdvance\Sitemap\PageType\PageTypeConfiguration;
use PHPUnit\Framework\TestCase;

class PageTypeConfigurationTest extends TestCase
{
    public function testGetters(): void
    {
        $objectType = 'someObjectType';
        $changeFrequency = 'daily';
        $priority = 0.35;

        $sut = new PageTypeConfiguration(
            objectType: $objectType,
            changeFrequency: $changeFrequency,
            priority: $priority,
        );

        $this->assertSame($objectType, $sut->getObjectType());
        $this->assertSame($changeFrequency, $sut->getChangeFrequency());
        $this->assertSame($priority, $sut->getPriority());
    }
}

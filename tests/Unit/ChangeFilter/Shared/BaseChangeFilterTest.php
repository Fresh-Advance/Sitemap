<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace ChangeFilter\Shared;

use FreshAdvance\Sitemap\ChangeFilter\Shared\BaseChangeFilter;
use PHPUnit\Framework\TestCase;

/**
 * @covers \FreshAdvance\Sitemap\ChangeFilter\Shared\BaseChangeFilter
 */
class BaseChangeFilterTest extends TestCase
{
    public function testGetObjectType(): void
    {
        $objectType = uniqid();

        $sut = $this->getMockForAbstractClass(BaseChangeFilter::class, [$objectType]);

        $this->assertSame($objectType, $sut->getObjectType());
    }
}

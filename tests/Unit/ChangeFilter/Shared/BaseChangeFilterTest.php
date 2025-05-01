<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace ChangeFilter\Shared;

use FreshAdvance\Sitemap\ChangeFilter\Shared\BaseChangeFilter;
use PHPUnit\Framework\TestCase;

class BaseChangeFilterTest extends TestCase
{
    public function testGetObjectType(): void
    {
        $objectType = uniqid();

        $sut = $this->getMockBuilder(BaseChangeFilter::class)
            ->setConstructorArgs([$objectType])
            ->onlyMethods(['getUpdatedUrls', 'getDisabledUrlIds'])
            ->getMock();

        $this->assertSame($objectType, $sut->getObjectType());
    }
}

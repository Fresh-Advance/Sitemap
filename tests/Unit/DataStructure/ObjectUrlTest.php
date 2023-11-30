<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\DataStructure;

use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;

/**
 * @covers \FreshAdvance\Sitemap\DataStructure\ObjectUrl
 */
class ObjectUrlTest extends \PHPUnit\Framework\TestCase
{
    public function testMainGetters(): void
    {
        $urlStub = $this->createStub(PageUrlInterface::class);

        $sut = new ObjectUrl(
            objectId: 'idExample',
            objectType: 'typeExample',
            url: $urlStub
        );

        $this->assertSame('idExample', $sut->getObjectId());
        $this->assertSame('typeExample', $sut->getObjectType());
        $this->assertSame($urlStub, $sut->getUrl());
    }
}

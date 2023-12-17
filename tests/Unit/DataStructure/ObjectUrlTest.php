<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\DataStructure;

use DateTime;
use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;

/**
 * @covers \FreshAdvance\Sitemap\DataStructure\ObjectUrl
 */
class ObjectUrlTest extends \PHPUnit\Framework\TestCase
{
    public function testMainGetters(): void
    {
        $sut = new ObjectUrl(
            objectId: 'idExample',
            objectType: 'typeExample',
            location: 'someUrl',
            modified: $dateExample = new DateTime()
        );

        $this->assertSame('idExample', $sut->getObjectId());
        $this->assertSame('typeExample', $sut->getObjectType());
        $this->assertSame('someUrl', $sut->getLocation());
        $this->assertSame($dateExample, $sut->getModified());
    }
}

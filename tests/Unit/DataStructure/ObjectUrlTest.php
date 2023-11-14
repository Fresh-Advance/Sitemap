<?php

namespace FreshAdvance\Sitemap\Tests\Unit\DataStructure;

use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;

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

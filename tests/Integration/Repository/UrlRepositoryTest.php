<?php

namespace FreshAdvance\Sitemap\Tests\Integration\Repository;

use FreshAdvance\Sitemap\DataStructure\Url;
use FreshAdvance\Sitemap\Repository\UrlRepository;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;

class UrlRepositoryTest extends IntegrationTestCase
{
    protected const EXISTING_OBJECT_ID = 'exampleObjectId';
    protected const EXISTING_OBJECT_TYPE = 'exampleObjectType';

    public function setUp(): void
    {
        parent::setUp();

        $sut = $this->getSut();
        $sut->addUrl(
            self::EXISTING_OBJECT_ID,
            self::EXISTING_OBJECT_TYPE,
            new Url(
                location: 'someLocation',
                lastModified: 'modifiedDate',
                changeFrequency: 'frequency',
                priority: 0.3
            )
        );
    }

    public function testGetUrl(): void
    {
        $sut = $this->getSut();
        $url = $sut->getUrl(self::EXISTING_OBJECT_ID, self::EXISTING_OBJECT_TYPE);

        $this->assertSame('someLocation', $url->getLocation());
        $this->assertSame('modifiedDate', $url->getLastModified());
        $this->assertSame('frequency', $url->getChangeFrequency());
        $this->assertSame(0.3, $url->getPriority());
    }

    protected function getSut(): UrlRepository
    {
        return $this->get(UrlRepository::class);
    }
}

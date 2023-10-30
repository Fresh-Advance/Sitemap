<?php

namespace FreshAdvance\Sitemap\Tests\Integration\ChangeFilter;

use FreshAdvance\Sitemap\DataStructure\Url;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use FreshAdvance\Sitemap\ChangeFilter\ContentChangeFilter;
use OxidEsales\EshopCommunity\Application\Model\Content;
use OxidEsales\EshopCommunity\Tests\Integration\IntegrationTestCase;

class ContentChangeFilterTest extends IntegrationTestCase
{
    public function testCheckCurrentUrlItem(): void
    {
        $this->addConcreteDateUrl('content', date("2023-10-01"));

        $this->createExampleContent('example1');
        $this->createExampleContent('example2');
        $this->createExampleContent('example3');

        /** @var ContentChangeFilter $sut */
        $sut = $this->get(ContentChangeFilter::class);

        $urls = $sut->getUpdatedUrls(2);
        $this->checkCurrentUrlItem($urls, 'example1');
        $urls->next();
        $this->checkCurrentUrlItem($urls, 'example2');
        $urls->next();
        $this->assertNull($urls->current());
    }

    protected function addConcreteDateUrl(string $type, string $date): void
    {
        /** @var UrlRepositoryInterface $urlRepository */
        $urlRepository = $this->get(UrlRepositoryInterface::class);
        $urlRepository->addUrl(
            objectId: 'someId',
            objectType: $type,
            urlData: new Url(
                location: 'example',
                lastModified: $date,
                changeFrequency: 'frequency',
                priority: 1
            )
        );
    }

    protected function createExampleContent(string $identifier): void
    {
        $content = oxNew(Content::class);
        $content->assign([
            'oxid' => $identifier,
            'oxtitle' => $identifier,
            'oxloadid' => $identifier
        ]);
        $content->save();
    }

    protected function checkCurrentUrlItem(\Generator $urls, string $value): void
    {
        /** @var Url $nextUrl */
        $nextUrl = $urls->current();
        $this->assertSame($value, $urls->key());
        $this->assertSame('http://localhost.local/' . $value . '/', $nextUrl->getLocation());
        $this->assertNotEmpty($nextUrl->getLastModified());
        $this->assertSame('never', $nextUrl->getChangeFrequency());
        $this->assertSame(0.5, $nextUrl->getPriority());
    }
}

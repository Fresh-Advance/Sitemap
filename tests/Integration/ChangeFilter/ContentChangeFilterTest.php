<?php

namespace FreshAdvance\Sitemap\Tests\Integration\ChangeFilter;

use FreshAdvance\Sitemap\ChangeFilter\ContentChangeFilter;
use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\ObjectUrlInterface;
use FreshAdvance\Sitemap\DataStructure\PageUrl;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use FreshAdvance\Sitemap\Tests\Integration\IntegrationTestCase;
use OxidEsales\EshopCommunity\Application\Model\Content;

/**
 * @covers \FreshAdvance\Sitemap\ChangeFilter\ContentChangeFilter
 */
class ContentChangeFilterTest extends IntegrationTestCase
{
    public function testCheckCurrentUrlItem(): void
    {
        $connection = $this->getConnection();
        $connection->executeQuery("update oxcontents set oxtimestamp='2023-09-01'");

        $this->addConcreteDateUrl('content', new \DateTime("2023-10-01"));

        $this->createExampleContent('example1');
        $this->createExampleContent('example2');
        $this->createExampleContent('example3');

        /** @var ContentChangeFilter $sut */
        $sut = $this->get(ContentChangeFilter::class);
        $urls = $sut->getUpdatedUrls(2);

        $this->checkCurrentUrlItem($urls->current(), 'example1');

        $urls->next();
        $this->checkCurrentUrlItem($urls->current(), 'example2');

        $urls->next();
        $this->assertNull($urls->current());
    }

    protected function addConcreteDateUrl(string $type, \DateTime $dateTime): void
    {
        /** @var UrlRepositoryInterface $urlRepository */
        $urlRepository = $this->get(UrlRepositoryInterface::class);
        $urlRepository->addObjectUrl(
            new ObjectUrl(
                objectId: 'someId',
                objectType: $type,
                url: new PageUrl(
                    location: 'example',
                    lastModified: $dateTime,
                    changeFrequency: 'frequency',
                    priority: 1
                )
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

    protected function checkCurrentUrlItem(ObjectUrlInterface $objectUrl, string $value): void
    {
        $this->assertSame('content', $objectUrl->getObjectType());

        $url = $objectUrl->getUrl();
        $this->assertSame('http://localhost.local/' . $value . '/', $url->getLocation());
        $this->assertNotEmpty($url->getLastModified());
        $this->assertSame('never', $url->getChangeFrequency());
        $this->assertSame(0.5, $url->getPriority());
    }
}

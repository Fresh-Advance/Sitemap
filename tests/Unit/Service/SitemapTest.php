<?php

namespace FreshAdvance\Sitemap\Tests\Unit\Service;

use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use FreshAdvance\Sitemap\Service\Filesystem;
use FreshAdvance\Sitemap\Service\Sitemap;
use FreshAdvance\Sitemap\Service\XmlGeneratorInterface;

class SitemapTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerateSitemap(): void
    {
        $filesystemMock = $this->createMock(Filesystem::class);
        $filesystemMock->expects($this->once())
            ->method('createSitemapFile')
            ->with('sitemap.xml', 'someContent');

        $repositoryResponse = ['someItemsArray'];
        $urlRepositoryStub = $this->createMock(UrlRepositoryInterface::class);
        $urlRepositoryStub->method('getUrlsByType')->with('', 1, 50000)->willReturn($repositoryResponse);

        $xmlGeneratorMock = $this->createMock(XmlGeneratorInterface::class);
        $xmlGeneratorMock->expects($this->once())
            ->method('generateSitemapDocument')
            ->with($repositoryResponse)
            ->willReturn('someContent');

        $sut = new Sitemap(
            filesystemService: $filesystemMock,
            urlRepository: $urlRepositoryStub,
            xmlGeneratorService: $xmlGeneratorMock
        );
        $sut->generateSitemap();
    }
}

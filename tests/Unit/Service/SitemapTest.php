<?php

namespace FreshAdvance\Sitemap\Tests\Unit\Service;

use FreshAdvance\Sitemap\DataStructure\PageUrlInterface;
use FreshAdvance\Sitemap\DataStructure\SitemapUrlInterface;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use FreshAdvance\Sitemap\Service\Filesystem;
use FreshAdvance\Sitemap\Service\FilesystemInterface;
use FreshAdvance\Sitemap\Service\LocationServiceInterface;
use FreshAdvance\Sitemap\Service\Sitemap;
use FreshAdvance\Sitemap\Service\XmlGeneratorInterface;

/**
 * @covers \FreshAdvance\Sitemap\Service\Sitemap
 */
class SitemapTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerateSitemapCreatesAllPagesAndIndexFile(): void
    {
        $sut = $this->getMockBuilder(Sitemap::class)
            ->setConstructorArgs([
                'filesystemService' => $filesystemMock = $this->createMock(FilesystemInterface::class),
                'urlRepository' => $urlRepositoryStub = $this->createMock(UrlRepositoryInterface::class),
                'xmlGeneratorService' => $xmlGeneratorMock = $this->createMock(XmlGeneratorInterface::class),
                'locationService' => $locationServiceStub = $this->createStub(LocationServiceInterface::class)
            ])
            ->onlyMethods(['generateSitemapPage'])
            ->getMock();

        $sut->expects($this->exactly(2))
            ->method('generateSitemapPage')
            ->willReturnMap([
                [1, 'sitemap_page_1.xml', $url1 = $this->createStub(SitemapUrlInterface::class)],
                [2, 'sitemap_page_2.xml', $url2 = $this->createStub(SitemapUrlInterface::class)],
            ]);

        $urlRepositoryStub->method('getUrlsCount')->willReturn(75000);
        $locationServiceStub->method('getSitemapDirectoryPath')->willReturn('directoryPath');

        $xmlGeneratorMock->method('generateSitemapIndexDocument')
            ->with([$url1, $url2])
            ->willReturn('someIndexFileContent');

        $filesystemMock->expects($this->once())
            ->method('createSitemapFile')
            ->with('directoryPath', 'sitemap.xml', 'someIndexFileContent');

        $sut->generateSitemap();
    }

    public function testGenerateSitemapPageSavesLimitedRepositoryUrlsToFileAndReturnsItsUrl(): void
    {
        $repositoryResponse = [$this->createStub(PageUrlInterface::class)];
        $urlRepositoryStub = $this->createMock(UrlRepositoryInterface::class);
        $urlRepositoryStub->method('getUrls')
            ->with(3, 50000)
            ->willReturn($repositoryResponse);

        $xmlGeneratorMock = $this->createMock(XmlGeneratorInterface::class);
        $xmlGeneratorMock->method('generateSitemapDocument')
            ->with($repositoryResponse)
            ->willReturn($exampleXmlContent = 'xmlFileContent');

        $locationServiceMock = $this->createMock(LocationServiceInterface::class);
        $locationServiceMock->method('getSitemapDirectoryPath')->willReturn($sitemapDirectory = 'exampleDirectory');
        $locationServiceMock->method('getSitemapFileUrl')
            ->with($sitemapFileName = 'sitemapFileName')
            ->willReturn($urlExample = $this->createStub(SitemapUrlInterface::class));

        $filesystemMock = $this->createMock(Filesystem::class);
        $filesystemMock->expects($this->once())
            ->method('createSitemapFile')
            ->with($sitemapDirectory, $sitemapFileName, $exampleXmlContent);

        $sut = $this->getSut(
            filesystemService: $filesystemMock,
            urlRepository: $urlRepositoryStub,
            xmlGeneratorService: $xmlGeneratorMock,
            locationService: $locationServiceMock,
        );

        $this->assertSame($urlExample, $sut->generateSitemapPage(3, $sitemapFileName));
    }

    public function getSut(
        FilesystemInterface $filesystemService = null,
        UrlRepositoryInterface $urlRepository = null,
        XmlGeneratorInterface $xmlGeneratorService = null,
        LocationServiceInterface $locationService = null,
    ): Sitemap {
        return new Sitemap(
            filesystemService: $filesystemService ?? $this->createStub(FilesystemInterface::class),
            urlRepository: $urlRepository ?? $this->createStub(UrlRepositoryInterface::class),
            xmlGeneratorService: $xmlGeneratorService ?? $this->createStub(XmlGeneratorInterface::class),
            locationService: $locationService ?? $this->createStub(LocationServiceInterface::class),
        );
    }
}

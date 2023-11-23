<?php

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\SitemapUrlInterface;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;

class Sitemap
{
    public function __construct(
        protected FilesystemInterface $filesystemService,
        protected UrlRepositoryInterface $urlRepository,
        protected XmlGeneratorInterface $xmlGeneratorService,
        protected LocationServiceInterface $locationService,
    ) {
    }

    public function generateSitemap(): void
    {
        $perPage = 50000;

        $pageUrls = [];
        for ($page = 1; $page <= $this->getPagesCount($perPage); $page++) {
            $fileName = 'sitemap_page_' . $page . '.xml';
            $pageUrls[] = $this->generateSitemapPage($page, $fileName);
        }

        $this->filesystemService->createSitemapFile(
            $this->locationService->getSitemapDirectoryPath(),
            'sitemap.xml',
            $this->xmlGeneratorService->generateSitemapIndexDocument($pageUrls)
        );
    }

    protected function getPagesCount(int $perPage): int
    {
        return (int)ceil($this->urlRepository->getUrlsCount() / $perPage);
    }

    public function generateSitemapPage(int $page, string $fileName): SitemapUrlInterface
    {
        $perPage = 50000;

        $urls = $this->urlRepository->getUrls($page, $perPage);
        $content = $this->xmlGeneratorService->generateSitemapDocument($urls);

        $this->filesystemService->createSitemapFile(
            directory: $this->locationService->getSitemapDirectoryPath(),
            fileName: $fileName,
            content: $content
        );

        return $this->locationService->getSitemapFileUrl($fileName);
    }
}

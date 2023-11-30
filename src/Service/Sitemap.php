<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\SitemapUrlInterface;
use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;
use FreshAdvance\Sitemap\Settings\LocationServiceInterface;

class Sitemap implements SitemapInterface
{
    public const URLS_PER_PAGE = 50000;

    public function __construct(
        protected FilesystemInterface $filesystemService,
        protected UrlRepositoryInterface $urlRepository,
        protected XmlGeneratorInterface $xmlGeneratorService,
        protected LocationServiceInterface $locationService,
    ) {
    }

    public function generateSitemap(): void
    {
        $pageUrls = $this->generateSitemapPages();
        $this->generateSitemapIndex($pageUrls);
    }

    /**
     * @return array<SitemapUrlInterface>
     */
    private function generateSitemapPages(): array
    {
        $pageUrls = [];
        for ($page = 1; $page <= $this->getPagesCount(); $page++) {
            $fileName = 'sitemap_page_' . $page . '.xml';
            $pageUrls[] = $this->generateOneSitemapPage($page, $fileName);
        }
        return $pageUrls;
    }

    public function generateOneSitemapPage(int $page, string $fileName): SitemapUrlInterface
    {
        $urls = $this->urlRepository->getUrls($page, self::URLS_PER_PAGE);
        $this->filesystemService->createSitemapFile(
            directory: $this->locationService->getSitemapDirectoryPath(),
            fileName: $fileName,
            content: $this->xmlGeneratorService->generateSitemapDocument($urls)
        );

        return $this->locationService->getSitemapFileUrl($fileName);
    }

    private function getPagesCount(): int
    {
        return (int)ceil($this->urlRepository->getUrlsCount() / self::URLS_PER_PAGE);
    }

    /**
     * @param array<SitemapUrlInterface> $pageUrls
     */
    private function generateSitemapIndex(array $pageUrls): void
    {
        $this->filesystemService->createSitemapFile(
            directory: $this->locationService->getSitemapDirectoryPath(),
            fileName: 'sitemap.xml',
            content: $this->xmlGeneratorService->generateSitemapIndexDocument($pageUrls)
        );
    }
}

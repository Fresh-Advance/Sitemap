<?php

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;

class Sitemap
{
    public function __construct(
        protected Filesystem $filesystemService,
        protected UrlRepositoryInterface $urlRepository,
        protected XmlGeneratorInterface $xmlGeneratorService
    ) {
    }

    public function generateSitemap(): void
    {
        $items = $this->urlRepository->getUrlsByType('', 1, 50000);
        $xmlContent = $this->xmlGeneratorService->generateSitemapDocument($items);
        $this->filesystemService->createSitemapFile("sitemap.xml", $xmlContent);
    }
}

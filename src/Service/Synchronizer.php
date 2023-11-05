<?php

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\Repository\UrlRepositoryInterface;

class Synchronizer implements SynchronizerInterface
{
    public function __construct(
        private FilterServiceInterface $filterService,
        private UrlRepositoryInterface $urlRepository
    ) {
    }

    public function updateTypeUrls(string $type): int
    {
        $filter = $this->filterService->getFilter($type);
        $urls = $filter->getUpdatedUrls(100);

        $count = 0;
        foreach ($urls as $key => $oneUrl) {
            $count++;
            $this->urlRepository->addUrl($key, $type, $oneUrl);
        }

        return $count;
    }
}

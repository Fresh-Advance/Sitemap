<?php

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\DataStructure\ObjectUrl;
use FreshAdvance\Sitemap\DataStructure\UrlInterface;
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

        /** @var iterable<string, UrlInterface> $urls */
        $urls = $filter->getUpdatedUrls(100);

        $count = 0;
        foreach ($urls as $key => $oneUrl) {
            $count++;
            $this->urlRepository->addObjectUrl(
                new ObjectUrl(
                    objectId: $key,
                    objectType: $type,
                    url: $oneUrl
                )
            );
        }

        return $count;
    }
}

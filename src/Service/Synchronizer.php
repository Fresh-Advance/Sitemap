<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Service;

use FreshAdvance\Sitemap\ChangeFilter\FilterFactoryInterface;
use FreshAdvance\Sitemap\Url\Repository\UrlRepositoryInterface;

class Synchronizer implements SynchronizerInterface
{
    public function __construct(
        private FilterFactoryInterface $filterService,
        private UrlRepositoryInterface $urlRepository
    ) {
    }

    public function updateTypeUrls(string $type): int
    {
        $filter = $this->filterService->getFilter($type);
        $urls = $filter->getUpdatedUrls(100);

        $count = 0;
        foreach ($urls as $oneObjectUrl) {
            $this->urlRepository->addObjectUrl($oneObjectUrl);
            $count++;
        }

        return $count;
    }
}

<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Integration\Service;

use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;
use FreshAdvance\Sitemap\Url\Repository\UrlRepositoryInterface;

class Synchronizer implements SynchronizerInterface
{
    public function __construct(
        private UrlRepositoryInterface $urlRepository
    ) {
    }

    public function updateUrlsByFilter(ChangeFilterInterface $changeFilter): int
    {
        $urls = $changeFilter->getUpdatedUrls(100);

        $count = 0;
        foreach ($urls as $oneObjectUrl) {
            $this->urlRepository->addObjectUrl($oneObjectUrl);
            $count++;
        }

        return $count;
    }

    public function cleanupUrlsByFilter(ChangeFilterInterface $changeFilter): int
    {
        $ids = $changeFilter->getDisabledUrlIds();
        $this->urlRepository->deleteByIds($ids);

        return count($ids);
    }
}

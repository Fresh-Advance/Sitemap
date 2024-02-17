<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Integration\Service;

use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;

interface SynchronizerInterface
{
    public function updateUrlsByFilter(ChangeFilterInterface $changeFilter): int;

    public function cleanupUrlsByFilter(ChangeFilterInterface $changeFilter): int;
}

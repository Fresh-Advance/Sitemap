<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Integration\Service;

interface SynchronizerInterface
{
    public function updateTypeUrls(string $type): int;
}

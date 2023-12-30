<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Integration\Contract;

use FreshAdvance\Sitemap\Integration\DataType\ObjectUrlInterface;

interface ChangeFilterInterface
{
    public function getObjectType(): string;

    /** @return iterable<\FreshAdvance\Sitemap\Integration\DataType\ObjectUrlInterface> */
    public function getUpdatedUrls(int $limit): iterable;
}

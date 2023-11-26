<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Settings;

interface ModuleSettingsInterface
{
    public function getSitemapInSourceDirectory(): string;
}

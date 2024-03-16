<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

namespace FreshAdvance\Sitemap\Settings;

interface ModuleSettingsInterface
{
    public function getSitemapInSourceDirectory(): string;

    public function getAdditionalSitemapUrls(): array;
}

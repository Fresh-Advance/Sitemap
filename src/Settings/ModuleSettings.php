<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Settings;

/**
 * @todo: make sitemap setting editable
 */
class ModuleSettings implements ModuleSettingsInterface
{
    public function getSitemapInSourceDirectory(): string
    {
        return 'sitemap';
    }
}

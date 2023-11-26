<?php

namespace FreshAdvance\Sitemap\Settings;

// todo: make sitemap setting editable
use FreshAdvance\Sitemap\Settings\ModuleSettingsInterface;

class ModuleSettings implements ModuleSettingsInterface
{
    public function getSitemapInSourceDirectory(): string
    {
        return 'sitemap';
    }
}

<?php

namespace FreshAdvance\Sitemap\Service;

// todo: make sitemap setting editable
class ModuleSettings implements ModuleSettingsInterface
{
    public function getSitemapInSourceDirectory(): string
    {
        return 'sitemap';
    }
}

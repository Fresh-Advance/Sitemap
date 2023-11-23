<?php

namespace FreshAdvance\Sitemap\Service;

class ModuleSettings implements ModuleSettingsInterface
{
    public function getSitemapInSourceDirectory(): string
    {
        return 'sitemap';
    }
}

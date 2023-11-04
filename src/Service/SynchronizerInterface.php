<?php

namespace FreshAdvance\Sitemap\Service;

interface SynchronizerInterface
{
    public function updateTypeUrls(string $type): int;
}

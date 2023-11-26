<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Unit\Settings;

use FreshAdvance\Sitemap\Settings\ModuleSettings;
use PHPUnit\Framework\TestCase;

class ModuleSettingsTest extends TestCase
{
    public function testSitemapDirectorySetting(): void
    {
        $sut = new ModuleSettings();

        $this->assertSame('sitemap', $sut->getSitemapInSourceDirectory());
    }
}

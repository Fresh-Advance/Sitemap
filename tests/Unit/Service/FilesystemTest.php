<?php

namespace FreshAdvance\Sitemap\Tests\Unit\Service;

use FreshAdvance\Sitemap\Service\Filesystem;
use FreshAdvance\Sitemap\Service\ModuleSettings;
use org\bovigo\vfs\vfsStream;

class FilesystemTest extends \PHPUnit\Framework\TestCase
{
    public function testCreateSitemapFile(): void
    {
        $vfs = vfsStream::setup();

        $moduleSettings = $this->createConfiguredMock(ModuleSettings::class, [
            'getSitemapDirectory' => $vfs->url()
        ]);

        $sut = new Filesystem($moduleSettings);
        $expectedContent = 'someContent';
        $sitemapFileName = 'filePath.xml';
        $sut->createSitemapFile($sitemapFileName, $expectedContent);

        $fullSitemapFileName = $vfs->url() . DIRECTORY_SEPARATOR . $sitemapFileName;
        $this->assertTrue(is_file($fullSitemapFileName), "File with sitemap is not created");
        $realContent = file_get_contents($fullSitemapFileName);
        $this->assertSame($expectedContent, $realContent);
    }
}

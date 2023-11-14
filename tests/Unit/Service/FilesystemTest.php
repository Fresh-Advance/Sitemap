<?php

namespace FreshAdvance\Sitemap\Tests\Unit\Service;

use FreshAdvance\Sitemap\Service\Filesystem;
use FreshAdvance\Sitemap\Service\ModuleSettings;
use org\bovigo\vfs\vfsStream;

/**
 * @covers \FreshAdvance\Sitemap\Service\Filesystem
 */
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

    public function testCleanupSitemapFiles(): void
    {
        $startFiles = [
            'txtFile.txt' => 'content',
            'otherFile.pdf' => 'content',
            'example.xml' => 'content',
            'exampleSitemap.xml' => 'content',
            'sitemap.xml' => 'content',
            'sitemap.xml.gz' => 'content',
            'sitemap_part_5.xml' => 'content',
            'sitemap_part_5.xml.gz' => 'content',
            'sitemap.xml.php' => 'content',
        ];

        $toRemove = [
            'sitemap.xml',
            'sitemap.xml.gz',
            'sitemap_part_5.xml',
            'sitemap_part_5.xml.gz',
        ];

        $toStay = [
            'txtFile.txt',
            'otherFile.pdf',
            'example.xml',
            'exampleSitemap.xml',
            'sitemap.xml.php',
        ];

        $vfs = vfsStream::setup('root', 0777, $startFiles);
        $vfsPath = $vfs->url($vfs->path());

        $moduleSettings = $this->createConfiguredMock(ModuleSettings::class, [
            'getSitemapDirectory' => $vfsPath
        ]);

        $sut = new Filesystem(moduleSettings: $moduleSettings);
        $sut->cleanupSitemapFiles();

        $files = scandir($vfsPath);

        foreach ($toStay as $oneFile) {
            $this->assertTrue(
                in_array($oneFile, $files),
                sprintf("File %s was removed, but should not be.", $oneFile)
            );
        }

        foreach ($toRemove as $oneFile) {
            $this->assertFalse(
                in_array($oneFile, $files),
                sprintf("File %s was NOT removed, but should be.", $oneFile)
            );
        }
    }
}

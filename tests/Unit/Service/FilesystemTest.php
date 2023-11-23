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

        $fileName = 'filename.xml';
        $directory = $vfs->url();
        $exampleContent = 'someContent';

        $sut = new Filesystem();

        $filePath = $sut->createSitemapFile($directory, $fileName, $exampleContent);

        $this->assertSame($directory . '/' . $fileName, $filePath);

        $this->assertTrue(is_file($filePath), "File with sitemap is not created");
        $this->assertSame($exampleContent, file_get_contents($filePath));
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
        $directory = $vfs->url();

        $sut = new Filesystem();
        $sut->cleanupSitemapFiles($directory);

        $files = scandir($directory);

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

<?php

namespace FreshAdvance\Sitemap\Tests\Integration\Command;

use FreshAdvance\Sitemap\Command\GenerateSitemapCommand;
use FreshAdvance\Sitemap\Service\Sitemap;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \FreshAdvance\Sitemap\Command\GenerateSitemapCommand
 */
class GenerateSitemapCommandTest extends \PHPUnit\Framework\TestCase
{
    public function testCallSitemapCreationService(): void
    {
        $sitemapServiceMock = $this->createMock(Sitemap::class);
        $sitemapServiceMock->expects($this->once())->method('generateSitemap');

        $command = new GenerateSitemapCommand($sitemapServiceMock);

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
    }
}

<?php

namespace FreshAdvance\Sitemap\Tests\Integration\Command;

use FreshAdvance\Sitemap\Command\GenerateSitemapCommand;
use FreshAdvance\Sitemap\Service\SitemapInterface;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \FreshAdvance\Sitemap\Command\GenerateSitemapCommand
 */
class GenerateSitemapCommandTest extends \PHPUnit\Framework\TestCase
{
    public function testCallSitemapCreationService(): void
    {
        $command = new GenerateSitemapCommand(
            sitemapService: $sitemapServiceMock = $this->createMock(SitemapInterface::class)
        );

        $sitemapServiceMock->expects($this->once())->method('generateSitemap');

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
    }
}

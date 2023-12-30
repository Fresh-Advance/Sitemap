<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\Sitemap\Command;

use FreshAdvance\Sitemap\Sitemap\Command\GenerateSitemapCommand;
use FreshAdvance\Sitemap\Sitemap\Service\SitemapInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \FreshAdvance\Sitemap\Sitemap\Command\GenerateSitemapCommand
 */
class GenerateSitemapCommandTest extends TestCase
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

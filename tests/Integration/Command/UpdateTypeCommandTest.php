<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace Command;

use FreshAdvance\Sitemap\Integration\Service\Synchronizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \FreshAdvance\Sitemap\Integration\Command\UpdateTypeCommand
 */
class UpdateTypeCommandTest extends TestCase
{
    public function testUpdateTypeUrls(): void
    {
        $command = new \FreshAdvance\Sitemap\Integration\Command\UpdateTypeCommand(
            synchronizer: $dataSynchronizerMock = $this->createMock(Synchronizer::class),
        );

        $dataSynchronizerMock->expects($this->once())->method('updateTypeUrls')->with('someType');

        $commandTester = new CommandTester($command);
        $commandTester->execute(['type' => 'someType']);
    }
}

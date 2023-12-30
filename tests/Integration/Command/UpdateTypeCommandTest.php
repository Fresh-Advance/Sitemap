<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace Command;

use FreshAdvance\Sitemap\Command\UpdateTypeCommand;
use FreshAdvance\Sitemap\Service\Synchronizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \FreshAdvance\Sitemap\Command\UpdateTypeCommand
 */
class UpdateTypeCommandTest extends TestCase
{
    public function testUpdateTypeUrls(): void
    {
        $command = new UpdateTypeCommand(
            synchronizer: $dataSynchronizerMock = $this->createMock(Synchronizer::class),
        );

        $dataSynchronizerMock->expects($this->once())->method('updateTypeUrls')->with('someType');

        $commandTester = new CommandTester($command);
        $commandTester->execute(['type' => 'someType']);
    }
}

<?php

namespace Command;

use FreshAdvance\Sitemap\Command\UpdateTypeCommand;
use FreshAdvance\Sitemap\Service\Synchronizer;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \FreshAdvance\Sitemap\Command\UpdateTypeCommand
 */
class UpdateTypeCommandTest extends \PHPUnit\Framework\TestCase
{
    public function testUpdateTypeUrls(): void
    {
        $command = new UpdateTypeCommand(
            synchronizer: $dataSynchronizerMock = $this->createMock(Synchronizer::class)
        );

        $dataSynchronizerMock->expects($this->once())->method('updateTypeUrls')->with('someType');

        $commandTester = new CommandTester($command);
        $commandTester->execute(['type' => 'someType']);
    }
}

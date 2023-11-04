<?php

namespace Command;

use FreshAdvance\Sitemap\Command\UpdateTypeCommand;
use FreshAdvance\Sitemap\Service\Synchronizer;
use Symfony\Component\Console\Tester\CommandTester;

class UpdateTypeCommandTest extends \PHPUnit\Framework\TestCase
{
    public function testUpdateTypeUrls(): void
    {
        $dataSynchronizerMock = $this->createMock(Synchronizer::class);
        $dataSynchronizerMock->expects($this->once())->method('updateTypeUrls')->with('someType');

        $command = new UpdateTypeCommand($dataSynchronizerMock);

        $commandTester = new CommandTester($command);
        $commandTester->execute(['type' => 'someType']);
    }
}

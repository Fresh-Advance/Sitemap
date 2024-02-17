<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\Integration\Command;

use FreshAdvance\Sitemap\Integration\Command\UpdateTypeCommand;
use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;
use FreshAdvance\Sitemap\Integration\Service\FilterFactoryInterface;
use FreshAdvance\Sitemap\Integration\Service\Synchronizer;
use FreshAdvance\Sitemap\Integration\Service\SynchronizerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \FreshAdvance\Sitemap\Integration\Command\UpdateTypeCommand
 */
class UpdateTypeCommandTest extends TestCase
{
    public function testUpdateTypeUrls(): void
    {
        $command = $this->getSut(
            synchronizer: $dataSynchronizerMock = $this->createMock(Synchronizer::class),
            filterFactory: $filterFactoryMock = $this->createMock(FilterFactoryInterface::class),
        );

        $exampleType = 'someType';
        $filterStub = $this->createStub(ChangeFilterInterface::class);
        $filterFactoryMock->method('getFilter')->with($exampleType)->willReturn($filterStub);
        $dataSynchronizerMock->expects($this->once())->method('updateUrlsByFilter')->with($filterStub);
        $dataSynchronizerMock->expects($this->once())->method('cleanupUrlsByFilter')->with($filterStub);

        $commandTester = new CommandTester($command);
        $commandTester->execute(['type' => $exampleType]);
    }

    public function getSut(
        SynchronizerInterface $synchronizer = null,
        FilterFactoryInterface $filterFactory = null,
    ): UpdateTypeCommand {
        return new UpdateTypeCommand(
            synchronizer: $synchronizer ?? $this->createMock(SynchronizerInterface::class),
            filterFactory: $filterFactory ?? $this->createMock(FilterFactoryInterface::class),
        );
    }
}

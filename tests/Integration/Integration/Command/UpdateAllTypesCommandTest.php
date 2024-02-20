<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Tests\Integration\Integration\Command;

use FreshAdvance\Sitemap\Integration\Command\UpdateAllTypesCommand;
use FreshAdvance\Sitemap\Integration\Contract\ChangeFilterInterface;
use FreshAdvance\Sitemap\Integration\Service\FilterFactoryInterface;
use FreshAdvance\Sitemap\Integration\Service\Synchronizer;
use FreshAdvance\Sitemap\Integration\Service\SynchronizerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @covers \FreshAdvance\Sitemap\Integration\Command\UpdateAllTypesCommand
 */
class UpdateAllTypesCommandTest extends TestCase
{
    public function testUpdateAllTypes(): void
    {
        $command = $this->getSut(
            synchronizer: $synchronizerSpy = $this->createMock(Synchronizer::class),
            filterFactory: $filterFactoryStub = $this->createMock(FilterFactoryInterface::class),
        );

        $filterFactoryStub->method('getFilters')->willReturn([
            $this->createStub(ChangeFilterInterface::class),
            $this->createStub(ChangeFilterInterface::class)
        ]);

        $synchronizerSpy->expects($this->exactly(2))->method('updateUrlsByFilter');
        $synchronizerSpy->expects($this->exactly(2))->method('cleanupUrlsByFilter');

        $commandTester = new CommandTester($command);
        $commandTester->execute([]);
    }

    public function getSut(
        SynchronizerInterface $synchronizer = null,
        FilterFactoryInterface $filterFactory = null,
    ): UpdateAllTypesCommand {
        return new UpdateAllTypesCommand(
            synchronizer: $synchronizer ?? $this->createMock(SynchronizerInterface::class),
            filterFactory: $filterFactory ?? $this->createMock(FilterFactoryInterface::class),
        );
    }
}

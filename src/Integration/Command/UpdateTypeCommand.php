<?php

/**
 * Copyright © MB Arbatos Klubas. All rights reserved.
 * See LICENSE file for license details.
 */

declare(strict_types=1);

namespace FreshAdvance\Sitemap\Integration\Command;

use FreshAdvance\Sitemap\Integration\Service\FilterFactoryInterface;
use FreshAdvance\Sitemap\Integration\Service\SynchronizerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateTypeCommand extends Command
{
    public function __construct(
        protected SynchronizerInterface $synchronizer,
        protected FilterFactoryInterface $filterFactory,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'type',
            InputArgument::REQUIRED,
            'What type of object do we update'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var string $type */
        $type = $input->getArgument('type');
        $filter = $this->filterFactory->getFilter($type);

        $updateCount = $this->synchronizer->updateUrlsByFilter($filter);
        $output->writeln("Updated items: " . $updateCount);

        $cleanupCount = $this->synchronizer->cleanupUrlsByFilter($filter);
        $output->writeln("Cleaned up items: " . $cleanupCount);

        return Command::SUCCESS;
    }
}

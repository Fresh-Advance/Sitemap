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

class UpdateAllTypesCommand extends Command
{
    public function __construct(
        protected SynchronizerInterface $synchronizer,
        protected FilterFactoryInterface $filterFactory,
    ) {
        parent::__construct();
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $filters = $this->filterFactory->getFilters();

        foreach ($filters as $oneFilter) {
            $updateCount = $this->synchronizer->updateUrlsByFilter($oneFilter);
            $output->writeln("Updated items: " . $updateCount);

            $cleanupCount = $this->synchronizer->cleanupUrlsByFilter($oneFilter);
            $output->writeln("Cleaned up items: " . $cleanupCount);
        }

        return Command::SUCCESS;
    }
}

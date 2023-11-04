<?php

namespace FreshAdvance\Sitemap\Command;

use FreshAdvance\Sitemap\Service\SynchronizerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateTypeCommand extends Command
{
    public function __construct(
        private SynchronizerInterface $synchronizer
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

        $updateCount = $this->synchronizer->updateTypeUrls($type);
        $output->writeln("Updated items: " . $updateCount);

        return Command::SUCCESS;
    }
}

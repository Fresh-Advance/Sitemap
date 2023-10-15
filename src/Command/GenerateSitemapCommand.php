<?php

namespace FreshAdvance\Sitemap\Command;

use FreshAdvance\Sitemap\Service\Sitemap;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSitemapCommand extends Command
{
    public function __construct(
        protected Sitemap $sitemapServiceMock
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Generating sitemap...");

        $this->sitemapServiceMock->generateSitemap();

        return Command::SUCCESS;
    }
}

<?php

namespace FreshAdvance\Sitemap\Command;

use FreshAdvance\Sitemap\Service\SitemapInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateSitemapCommand extends Command
{
    public function __construct(
        protected SitemapInterface $sitemapService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Generating sitemap...");

        $this->sitemapService->generateSitemap();

        return Command::SUCCESS;
    }
}

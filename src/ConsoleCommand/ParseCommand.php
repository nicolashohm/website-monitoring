<?php

namespace WebsiteMonitoring\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParseCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('parse')
            ->setDescription('Parse the config and output the result')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO
    }
}

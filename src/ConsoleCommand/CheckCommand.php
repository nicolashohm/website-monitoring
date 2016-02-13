<?php

namespace WebsiteMonitoring\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('check')
            ->setDescription('Main command to execute the checks. In case of failure the exit code is not 0')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO
    }
}

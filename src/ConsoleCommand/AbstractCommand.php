<?php

namespace WebsiteMonitoring\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use WebsiteMonitoring\CheckerPluginManager;

/**
 * @property CheckerPluginManager checkerPluginManager
 */
class AbstractCommand extends Command
{
    public function setCheckerPluginManager(CheckerPluginManager $checkerPluginManager)
    {
        $this->checkerPluginManager = $checkerPluginManager;
        return $this;
    }

    /**
     * @param OutputInterface $output
     * @param $checkerName
     */
    protected function writeCheckerHeading(OutputInterface $output, $checkerName)
    {
        $output->writeln('');
        $output->writeln('Checker: ' . $checkerName);
        $output->writeln('');
    }
}

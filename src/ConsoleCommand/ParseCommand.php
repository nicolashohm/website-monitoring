<?php

namespace WebsiteMonitoring\ConsoleCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WebsiteMonitoring\Checker\CheckerInterface;
use WebsiteMonitoring\ConfigParser;
use WebsiteMonitoring\WebsiteConfig;

class ParseCommand extends AbstractCommand
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
        $config = ConfigParser::createFromConfig(require 'config.php');
        /** @var WebsiteConfig $website */
        foreach ($config as $website) {
            foreach ($website->getChecker() as $checkerName => $checkerConfig) {
                /** @var CheckerInterface $checker */
                $checker = $this->checkerPluginManager->get($checkerName);
                $result = $checker->parse($website, $checkerConfig);
                $output->writeln($result);
            }
        }
    }
}

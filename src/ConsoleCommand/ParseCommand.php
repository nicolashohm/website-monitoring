<?php

namespace WebsiteMonitoring\ConsoleCommand;

use Symfony\Component\Console\Helper\FormatterHelper;
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
        /** @var FormatterHelper $formatter */
        $formatter = $this->getHelper('formatter');

        $config = ConfigParser::createFromConfig(require 'config.php');
        /** @var WebsiteConfig $website */
        foreach ($config as $website) {
            foreach ($website->getChecker() as $checkerName => $checkerConfig) {
                /** @var CheckerInterface $checker */
                $checker = $this->checkerPluginManager->get($checkerName);
                $result = $checker->parse($website, $checkerConfig);
                $result = $formatter->formatBlock($result, 'comment');
                $this->writeCheckerHeading($output, $checkerName);
                $output->writeln($result);
            }
        }
    }
}

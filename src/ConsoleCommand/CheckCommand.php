<?php

namespace WebsiteMonitoring\ConsoleCommand;

use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WebsiteMonitoring\Checker\CheckerInterface;
use WebsiteMonitoring\ConfigParser;
use WebsiteMonitoring\WebsiteConfig;

class CheckCommand extends AbstractCommand
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
        $statusCode = 0;
        $config = ConfigParser::createFromConfig(require 'config.php');
        /** @var WebsiteConfig $website */
        foreach ($config as $website) {
            foreach ($website->getChecker() as $checkerName => $checkerConfig) {
                /** @var CheckerInterface $checker */
                $checker = $this->checkerPluginManager->get($checkerName);
                $result = $checker->check($website, $checkerConfig);
                if (!empty($result)) {
                    $statusCode = 1;
                    $this->writeCheckerHeading($output, $checkerName);
                    /** @var FormatterHelper $formatter */
                    $formatter = $this->getHelper('formatter');
                    $result = $formatter->formatBlock($result, 'error');
                    $output->writeln($result);
                }
            }
        }
        return $statusCode;
    }
}

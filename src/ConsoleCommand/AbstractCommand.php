<?php

namespace WebsiteMonitoring\ConsoleCommand;

use Symfony\Component\Console\Command\Command;
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
}

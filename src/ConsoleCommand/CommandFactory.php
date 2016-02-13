<?php

namespace WebsiteMonitoring\ConsoleCommand;

use Interop\Container\ContainerInterface;
use WebsiteMonitoring\CheckerPluginManager;
use Zend\ServiceManager\Factory\AbstractFactoryInterface;

class CommandFactory implements AbstractFactoryInterface
{
    public function canCreate(ContainerInterface $container, $requestedName)
    {
        return is_subclass_of($requestedName, AbstractCommand::class);
    }

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        /** @var CheckerPluginManager $checker */
        $checker = $container->get(CheckerPluginManager::class);

        /** @var AbstractCommand $instance */
        $instance = new $requestedName();
        $instance->setCheckerPluginManager($checker);
        return $instance;
    }
}

<?php

namespace WebsiteMonitoring;

use WebsiteMonitoring\Checker\CheckerInterface;
use Zend\ServiceManager\AbstractPluginManager;

class CheckerPluginManager extends AbstractPluginManager
{
    /**
     * An object type that the created instance must be instanced of
     *
     * @var null|string
     */
    protected $instanceOf = CheckerInterface::class;
}

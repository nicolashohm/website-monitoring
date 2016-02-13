<?php

namespace WebsiteMonitoring\Checker;

use WebsiteMonitoring\WebsiteConfig;

class ImprintPage implements CheckerInterface
{
    public function check(WebsiteConfig $config, array $checkerConfig = [])
    {

    }

    public function parse(WebsiteConfig $config, array $checkerConfig = [])
    {
        return 'Check for "' . $this->getLink($config, $checkerConfig) . '" to exists';
    }

    public function getLink(WebsiteConfig $config, array $checkerConfig = [])
    {
        return $config->getUrl() . (!empty($checkerConfig['path']) ? $checkerConfig['path'] : '');
    }
}

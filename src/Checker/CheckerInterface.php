<?php

namespace WebsiteMonitoring\Checker;

use WebsiteMonitoring\WebsiteConfig;

interface CheckerInterface
{
    /**
     * Execute the check
     *
     * @param WebsiteConfig $config
     * @param array $checkerConfig
     *
     * @return mixed
     */
    public function check(WebsiteConfig $config, array $checkerConfig = []);

    /**
     * Parse the config and return the parse result
     *
     * @param WebsiteConfig $config
     * @param array $checkerConfig
     *
     * @return mixed
     */
    public function parse(WebsiteConfig $config, array $checkerConfig = []);
}

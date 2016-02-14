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
     * @return string|array String or array to output, if return is not empty we consider a failure occurs
     */
    public function check(WebsiteConfig $config, array $checkerConfig = []);

    /**
     * Parse the config and return the parse result
     *
     * @param WebsiteConfig $config
     * @param array $checkerConfig
     *
     * @return string|array String or array to output
     */
    public function parse(WebsiteConfig $config, array $checkerConfig = []);
}

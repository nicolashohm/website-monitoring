<?php

namespace WebsiteMonitoring;

/**
 * @property string url
 * @property array checker
 */
class WebsiteConfig
{
    public function __construct($url, array $checker)
    {
        $this->url = $url;
        $this->checker = $checker;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function getChecker()
    {
        return $this->checker;
    }
}

<?php

namespace WebsiteMonitoring\Checker;

use WebsiteMonitoring\WebsiteConfig;
use Zend\Http\Client;

class PageExists implements CheckerInterface
{
    public function check(WebsiteConfig $config, array $checkerConfig = [])
    {
        $failures = [];
        $client = new Client();
        foreach ($this->getLinks($config, $checkerConfig) as $link) {
            $response = $client->setUri($link)->send();
            !$response->isOk() && $failures[] = $link;
        }
        return $failures;
    }

    public function parse(WebsiteConfig $config, array $checkerConfig = [])
    {
        $result = ['Check for the following pages to exist:'];
        return array_merge($result, $this->getLinks($config, $checkerConfig));
    }

    protected function getLinks(WebsiteConfig $config, array $checkerConfig = [])
    {
        $result = [];
        foreach ($checkerConfig['pages'] as $page) {
            $result[] = $config->getUrl() . $page;
        }
        return $result;
    }
}

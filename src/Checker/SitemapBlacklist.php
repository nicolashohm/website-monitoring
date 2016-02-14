<?php

namespace WebsiteMonitoring\Checker;

use WebsiteMonitoring\WebsiteConfig;
use Zend\Http\Client;

class SitemapBlacklist implements CheckerInterface
{
    public function check(WebsiteConfig $config, array $checkerConfig = [])
    {
        $link = $this->getLink($config->getUrl(), $checkerConfig);
        $response = (new Client($link))->send();
        if (!$response->isOk()) {
            return [
                'Can not request the sitemap at ' . $link . '.',
                'The following error occurs: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase(),
            ];
        }
        if (empty($checkerConfig['blacklist'])) {
            return 'Config error, no blacklist configured';
        }
        $xml = new \SimpleXMLElement($response->getBody());
        $failures = [];
        foreach ($xml as $url) {
            foreach ($url as $item) {
                $item->getName() == 'loc'
                && in_array((string)$item, $this->getBlacklist($config->getUrl(), $checkerConfig['blacklist']))
                && $failures[] = 'Found ' . (string)$item . ' in sitemap';
            }
        }
        return $failures;
    }

    public function parse(WebsiteConfig $config, array $checkerConfig = [])
    {
        if (empty($checkerConfig['blacklist'])) {
            return 'Config error, no blacklist configured';
        }
        $blacklistString = implode(', ', $this->getBlacklist($config->getUrl(), $checkerConfig['blacklist']));
        return [
            'Check ' . $this->getLink($config->getUrl(), $checkerConfig),
            'With following blacklist: ' . $blacklistString,
        ];
    }

    private function getLink($url, array $checkerConfig = [])
    {
        $path = '/sitemap.xml';
        !empty($checkerConfig['path']) && $path = $checkerConfig['path'];
        return $url . $path;
    }

    private function getBlacklist($url, array $blacklist)
    {
        array_walk($blacklist, function (&$item) use ($url) {
            $item = $url . $item;
        });
        return $blacklist;
    }
}

<?php

namespace WebsiteMonitoring\Checker;

use WebsiteMonitoring\WebsiteConfig;
use Zend\Http\Client;

class RobotsTxt implements CheckerInterface
{
    public function check(WebsiteConfig $config, array $checkerConfig = [])
    {
        $client = new Client();
        $response = $client->setUri($this->getUrl($config))->send();
        if (!$response->isOk()) {
            return [
                'Can not request the robots.txt at ' . $this->getUrl($config) . '.',
                'The following error occurs: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase(),
            ];
        }

        if (empty($checkerConfig['disallows'])) {
            return 'Config error, no disallows configured';
        }

        return $this->checkDisallows($response->getBody(), $checkerConfig['disallows']);
    }

    public function parse(WebsiteConfig $config, array $checkerConfig = [])
    {
        $url = $this->getUrl($config);
        if (empty($checkerConfig['disallows'])) {
            return 'Config error, no disallows configured';
        }
        return [
            'Check for robots.txt at ' . $url,
            'With following disallows: ' . implode(', ', $checkerConfig['disallows']),
        ];
    }

    private function getUrl(WebsiteConfig $config)
    {
        return $config->getUrl() . '/robots.txt';
    }

    private function checkDisallows($body, array $disallows)
    {
        $failures = [];
        $body = explode("\n", $body);
        foreach ($disallows as $disallow) {
            if (!in_array('Disallow: ' . $disallow, $body)) {
                $failures[] = $disallow . ' missing in robots.txt';
            }
        }
        !empty($failures) && $failures = array_merge($failures, ['Current robots.txt: '], $body);
        return $failures;
    }
}

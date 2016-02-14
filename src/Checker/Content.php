<?php

namespace WebsiteMonitoring\Checker;

use WebsiteMonitoring\WebsiteConfig;
use Zend\Http\Client;

class Content implements CheckerInterface
{
    public function check(WebsiteConfig $config, array $checkerConfig = [])
    {
        $failures = [];
        foreach ($checkerConfig as $page) {
            if (empty($page['page'])) {
                $failures[] = 'Config error, no page defined';
                continue;
            }
            $link = $config->getUrl() . $page['page'];
            $response = (new Client($link))->send();
            if (!$response->isOk()) {
                $failures = array_merge($failures, [
                    'Can not request the sitemap at ' . $link . '.',
                    'The following error occurs: ' . $response->getStatusCode() . ' ' . $response->getReasonPhrase(),
                ]);
            }
            $failures = array_merge($failures, $this->checkPage($response->getBody(), $page));
        }
        return $failures;
    }

    private function checkPage($html, array $pageConfig)
    {
        $failures = [];
        $text = strip_tags(html_entity_decode($html));
        if (!empty($pageConfig['text_present'])) {
            foreach ((array)$pageConfig['text_present'] as $item) {
                strpos($text, $item) === false
                    && $failures[] = 'Can not find ' . $item . ' on page ' . $pageConfig['page'];
            }
        }
        if (!empty($pageConfig['text_not_present'])) {
            foreach ((array)$pageConfig['text_not_present'] as $item) {
                strpos($text, $item) !== false
                    && $failures[] = 'Found ' . $item . ' on page ' . $pageConfig['page'];
            }
        }
        if (!empty($pageConfig['html_present'])) {
            foreach ((array)$pageConfig['html_present'] as $item) {
                strpos($html, $item) === false
                    && $failures[] = 'Can not find  ' . $item . ' on page ' . $pageConfig['page'];
            }
        }
        if (!empty($pageConfig['html_not_present'])) {
            foreach ((array)$pageConfig['html_not_present'] as $item) {
                strpos($html, $item) !== false
                && $failures[] = 'Found ' . $item . ' on page ' . $pageConfig['page'];
            }
        }
        return $failures;
    }

    public function parse(WebsiteConfig $config, array $checkerConfig = [])
    {
        $result = [];

        foreach ($checkerConfig as $page) {
            if (empty($page['page'])) {
                return 'Config error, no page defined';
            }
            $result[] = 'Check page ' . $page['page'];
            if (!empty($page['text_present'])) {
                $result[] = 'For following text(s) are present: ' . implode(', ', (array)$page['text_present']);
            }
            if (!empty($page['text_not_present'])) {
                $result[] = 'For following text(s) are not present: ' . implode(', ', (array)$page['text_not_present']);
            }
            if (!empty($page['html_present'])) {
                $result[] = 'For following html are present: ' . implode(', ', (array)$page['html_present']);
            }
            if (!empty($page['html_not_present'])) {
                $result[] = 'For following html are not present: ' . implode(', ', (array)$page['html_not_present']);
            }
            return $result;
        }
    }
}

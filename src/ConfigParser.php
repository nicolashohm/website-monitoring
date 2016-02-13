<?php

namespace WebsiteMonitoring;

/**
 * @property array rawConfig
 */
class ConfigParser extends \ArrayObject
{
    public static function createFromConfig(array $config)
    {
        return new static($config);
    }

    public function __construct(array $config)
    {
        $this->rawConfig = $config;
        $this->parse($config);
    }

    private function parse($config)
    {
        if (empty($config['websites']) && !is_array($config['websites'])) {
            throw new \RuntimeException('Websites part in config is missing or invalid');
        }

        foreach ($config['websites'] as $website) {
            $this->validateWebsite($website);
            $this->append(new WebsiteConfig($website['url'], $website['checker']));
        }
    }

    private function validateWebsite($website)
    {
        if (empty($website['url'])) {
            throw new \RuntimeException('url for website is required');
        }

        if (empty($website['checker'])) {
            throw new \RuntimeException('No checker configured for website "' . $website['url'] . '"');
        }
    }

    /**
     * @return array
     */
    public function getRawConfig()
    {
        return $this->rawConfig;
    }
}

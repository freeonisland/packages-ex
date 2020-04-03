<?php

namespace App\Manager;

use App\Service\YamlParserService;
use App\Core\Container;

class ConfigManager extends Container
{
    /**
     * const
     */
    const NAME_CONTAINER = 'CONFIG';

    /**
     * vars
     */
    private $yamlParser;

    /**
     * Constructor
     */
    public function __construct(YamlParserService $yamlParser)
    {
        $this->yamlParser = $yamlParser;
    }

    public function loadFilepath(string $filepath): void
    {
        $values = $this->yamlParser->parse($filepath);

        if(!is_array($values)) {
            throw new \Exception('Returned Yaml parsed value is not an array');
            return;
        }

        array_walk($values, function($v, $k){
            $this->set($k, $v);
        });

        s($this);
    }
}
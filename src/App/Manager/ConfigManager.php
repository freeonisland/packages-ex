<?php

namespace App\Manager;

use App\Service\YamlParserService;

class ConfigManager
{
    private $filepath;
    private $yamlParser;

    public function __construct(YamlParserService $yamlParser)
    {
        $this->yamlParser = $yamlParser;
    }

    public function setFilepath(string $filepath): void
    {
        $this->filepath = $filepath;
    }

    public function getConfig(): array
    {
        return $this->yamlParser->parse($this->filepath);
    }
}
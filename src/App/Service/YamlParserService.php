<?php

namespace App\Service;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;

class YamlParserService
{
    public function parse(string $file): array
    {
        try {
            $value = Yaml::parseFile($file);
            return $value;
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
            return [];
        }
        //$value = Yaml::parseFile('/path/to/file.yaml');
        //echo Yaml::dump($array, 1);
        //$value = Yaml::parse("foo: bar");
    } 
}
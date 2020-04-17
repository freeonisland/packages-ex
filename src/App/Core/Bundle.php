<?php

namespace App\Core;

use App\Manager\ConfigManager;
use App\Service\YamlParserService;
use App\Core\Container;

/**
 * use for CLI phpunit
 */
class Bundle extends Container
{
    private $ns;

    private $configManager;

    public function __construct(string $ns)
    {
        $this->ns = $ns;
    
        $this->loadConfig();
        $this->loadModules();
    }

    public function getModule(string $module)
    {
        if($this->has($module)) {
            return $this->get($module);
        }
        throw new \InvalidArgumentException("Module $module not found");
    }

    private function getBasename()
    {
        $src_path = new \DirectoryIterator(APP_ROOT.'/src/');
        $basename=false;
        foreach($src_path as $sub_dir) {
            $dir_name = $sub_dir->getBasename();
            if(is_dir(APP_ROOT.'/src/'.$dir_name .'/'. $this->ns . '/src')) {
                $basename = APP_ROOT.'/src/'.$dir_name .'/'. $this->ns . '/src';
            }
        }

        if(!$basename) {
            throw new \FileNotFoundException("Basename $this->ns not found");
        }
        
        return $basename;
    }

    public function loadConfig()
    {
        $basename = $this->getBasename();

        // Config
        $config_file = "{$basename}/resources/config-" . strtolower($this->ns) . ".yml";
        
        if (file_exists($config_file)) {
            $configManager = new ConfigManager(new YamlParserService);
            $configManager->loadFilepath($config_file);
            //$this->set(ConfigManager::NAME_CONTAINER, $configManager);
        }

        $this->configManager = $configManager;
        return $configManager;
    }

    public function loadModules(): array
    {
        $basename = $this->getBasename();
        $config = $this->configManager??null;
        // modules
        $modules_file = "{$basename}/resources/modules-" . strtolower($this->ns) . ".php";
        
        if (file_exists($modules_file)) {

            $modules = include $modules_file;

            foreach($modules as $name => $module) {
                $this->set($name, $module);
            }
            
        }
        
        return $modules?$modules:[];
    }

    
}
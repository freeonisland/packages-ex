<?php

namespace App\Controller;

use App\Manager\ConfigManager;
use App\Core\Container;

class AbstractController 
{
    /**
     * Container
     */
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Get config parameter
     */
    public function getParam(string $id): string
    {
        /**
         * Check config exists
         */
        if(!$this->container->has(ConfigManager::NAME_CONTAINER)) {
            return '';
        }

        $configManager = $this->container->get(ConfigManager::NAME_CONTAINER);

        /**
         * Get from config params
         */
        if ($configManager->has($id)) {
            return $configManager->get($id);
        }
        return '';
    }
}
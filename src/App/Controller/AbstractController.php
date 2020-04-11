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
    protected $get;
    protected $post;



    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->getRequest();
    }

    public function getRequest()
    {
        $this->get = count(\Flight::request()->query) ? \Flight::request()->query : null;
        $this->post = count(\Flight::request()->data) ? \Flight::request()->data : null;
    }

    public function getModule(string $id)
    {
        /**
         * Check config exists
         */
        if(!$this->container->has($id)) {
            return '';
        }

        return $this->container->get($id);
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
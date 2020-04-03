<?php

namespace App\Controller;

use App\Manager\ConfigManager;
use App\Manager\ContainerManager;

class AbstractController 
{
    /**
     * Container
     */
    protected $container;

    public function __construct(ContainerManager $container)
    {
        $this->container = $container;
    }

    public function getParam(string $name): string
    {
        
    }
}
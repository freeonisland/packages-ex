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

    public function __construct()
    {
        
    }
}
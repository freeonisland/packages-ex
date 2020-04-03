<?php

namespace App\Core;

use Flight;
use App\Manager\ConfigManager;
use App\Service\YamlParserService;

class App
{
    const NAMESPACE_DEFAULT='App';
    const ACTION_DEFAULT='indexAction';
    const CONTROLLER_DEFAULT='IndexController';

    public static function run()
    {
        /**
         * Namespace
         * Controllers
         * @controllers @id:[0-9]{3}
         * @actions
         * @params
         * $route->params; $route->regex; $route->splat;
         */
        Flight::route('/(@ns(/@ctrl(/@action(/@params:.*))))', function($ns, $ctrl, $action, $params){
            // Array of HTTP methods matched against
            $ns = $ns ? ucfirst(strtolower(filter_var($ns, FILTER_SANITIZE_URL))) : self::NAMESPACE_DEFAULT;
            $c  = $ctrl ? ucfirst(strtolower(filter_var($ctrl, FILTER_SANITIZE_URL))) . 'Controller' : self::CONTROLLER_DEFAULT;
            $a  = $action ? strtolower(filter_var($action, FILTER_SANITIZE_URL)) . 'Action' : self::ACTION_DEFAULT;
            $p  = $params ? explode('/', strtolower(filter_var($params,FILTER_SANITIZE_URL))) : [];
        
            // Config
            $config_file = APP_ROOT . "/src/{$ns}/Resources/config-" . strtolower($ns) . ".yml";
            if (file_exists($config_file)) {
                $config = new ConfigManager( new YamlParserService );
                $config->setFilepath($config_file);
                $config = $config->getConfig();
            }

            //Class controller
            $class_ctrl = $ns . '\\Controller\\' . $c;
            $controller = new $class_ctrl;

            //Container
            

            $controller->$a(...$p);
        }, true);

        Flight::start();
    }
}
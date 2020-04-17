<?php

namespace App\Core;

use Flight;
use App\Core\Bundle;

class App
{
    const NAMESPACE_DEFAULT='App';
    const ACTION_DEFAULT='index';
    const CONTROLLER_DEFAULT='Index';

    public static function run()
    {
        /*Flight::map('error', function(\Error $er){
            // Handle error
            echo 'Error:'.$er->getMessage().'<br>';
            //echo $ex->getTraceAsString();
        });*/
                
        self::exceptionHandling();

        /*
        * Routes
        */
        self::setApiRoute();
        self::setAppRoute();
        Flight::start();
    }

    /*********
     * Private
     ********/
    private static function setApiRoute()
    {
        /**
         * @param api_ns array Api namespace (ex: api-ldap, api-storage...)
         * @param params array
         */
        
        Flight::route('/(@api_ns:api-[a-z]*(/@params:.*))', function(string $api_ns, $params) {
            echo $api_ns.' : '.$params;
            //$called = true;
        }, true);
    }

    private static function setAppRoute()
    {
        /**
         * Namespace
         * Controllers
         * @controllers @id:[0-9]{3}
         * @actions
         * @params
         * $route->params; $route->regex; $route->splat;
         */
        Flight::route('/(@ns(/@ctrl(/@action(/@params:.*))))', function($ns, $ctrl, $action, $params) {
            // Array of HTTP methods matched against
            $ctrl   = ($ctrl ? ucfirst(strtolower(filter_var($ctrl, FILTER_SANITIZE_URL))) : self::CONTROLLER_DEFAULT);
            $action = $action ? strtolower(filter_var($action, FILTER_SANITIZE_URL)) : self::ACTION_DEFAULT;

            $ns = $ns ? ucfirst(strtolower(filter_var($ns, FILTER_SANITIZE_URL))) : self::NAMESPACE_DEFAULT;
            $c  = $ctrl . 'Controller';
            $a  = $action . 'Action';
            $p  = $params ? explode('/', strtolower(filter_var($params,FILTER_SANITIZE_URL))) : [];

            //Container
            $container = new Container;

            
            /*
             * bundle
             */
            $bundle = new Bundle($ns);
            $bundle_config = $bundle->loadConfig();
            $container->set(\App\Manager\ConfigManager::NAME_CONTAINER, $bundle_config);

            $bundle_modules = $bundle->loadModules();
            foreach($bundle_modules as $name => $module) {
                $container->set($name, $module);
            }

        
            /*// Config
            $config_file = "{$basename}/resources/config-" . strtolower($ns) . ".yml";
            if (file_exists($config_file)) {
                $configManager = new ConfigManager(new YamlParserService);
                $configManager->loadFilepath($config_file);
                $container->set(ConfigManager::NAME_CONTAINER, $configManager);
            }

            
            // modules
            $config = $configManager??null;
            $modules_file = "{$basename}/resources/modules-" . strtolower($ns) . ".php";
            if (file_exists($modules_file)) {
                $modules = include $modules_file;
                foreach($modules as $name => $module) {
                    $container->set($name, $module);
                }
            }*/

            //Class controller
            $class_ctrl = $ns . '\\Controller\\' . $c;
            $controller = new $class_ctrl($container);
            $view_params = $controller->$a(...$p) ?: [];

            //View
            $view_path =  "{$basename}/resources/views/" . strtolower($ctrl);
            Flight::set('flight.views.path', $view_path);
            Flight::render($action, $view_params);

        }, true);

        //Flight::start();
    }

    private static function exceptionHandling()
    {
        set_exception_handler(function(\Exception $ex){
            echo 'Exception:'.$ex->getMessage().'<br>';
        });

        set_error_handler(function(\Error $ex){
            echo 'Error:'.$ex->getMessage().'<br>';
        });
    }
}
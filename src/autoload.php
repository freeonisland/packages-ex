<?php

//error_reporting(E_ALL);
//ini_set('dsplay_errors', 'on');

defined('APP_ROOT') or define ('APP_ROOT', realpath(__DIR__.'/../'));


/*$handler = function($errorNumber, $errorString, $errorFile, $errorLine) {
    echo "
ERROR INFO
Message: $errorString
File: $errorFile
Line: $errorLine
";
};
set_error_handler($handler);    */    


require __DIR__.'/../vendor/autoload.php';
//require __DIR__.'/../frame/vendor/autoload.php';
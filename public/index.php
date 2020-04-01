<?php declare(strict_types=1);

ini_set('display_errors','on');
error_reporting(E_ALL);

require '../vendor/autoload.php';

Flight::route('/', function(){
    echo 'Flight in action...';
});

Flight::start();
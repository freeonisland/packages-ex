<?php
declare(strict_types=1);

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use App\Factory\Factory;

class ControllerBase extends Controller
{
    // Implement common logic
    protected $get;
    
    protected static $F;

    public function onConstruct()
    {
        /*ini_set('session.save_handler','redis');
        ini_set('session.save_path','tcp://redis:6379');

        self::$F = new Factory;

        $this->redis = self::$F::getRedis();
        $this->session = self::$F::getSession();
        $soap = self::$F::getSoap();
        $ldap = self::$F::getLdap();

        $this->message = self::$F::getMessage();
        $this->user = self::$F::getUser();*/
    }

    protected function get($k)
    {
        $this->get = $_GET;
        if(isset($this->get[$k])) 
            return filter_var($this->get[$k], FILTER_SANITIZE_STRING);
    }

    protected function redirect($url='/')
    {
        header('Location: '.$url); die();
    }
}

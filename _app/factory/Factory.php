<?php

namespace App\Factory;

use App\Managers\RedisManager;
use App\Managers\SessionManager;
use App\Managers\SoapManager;

use App\Models\Message;
use App\Models\User;

class Factory
{
    static function getInstance()
    {
        return clone self;
    }

    static function getRedis()
    {
        return new RedisManager;
    }

    static function getUser()
    {
        return new User( self::getRedis() );
    }

    static function getMessage()
    {
        return new Message( self::getRedis() );
    }

    static function getSession()
    {
        return new SessionManager( self::getRedis() );
    }

    static function getSoap()
    {
        return new SoapManager;
    }

    static function getLdap()
    {
        
    }
}
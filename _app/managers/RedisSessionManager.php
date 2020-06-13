<?php
/*
 * This file is part of EventManager.
 */

namespace App\Managers;

use App\Adapters\DbAdapter;

class SessionManager
{
    const SESSION_DB = 'session:';
    //const SESSIONS_DB = 'sessions';

    const COOKIE_NAME = 'SESSIONIDREDIS';
    const COOKIE_TIME = 9960;

    /**
     * DATABASE user:0
     * DATABASE follower:2
     * DATABASE session:3
     * DATABASE message:4
     */
    const DB_SELECTED = 3;

    protected $db;
    //protected $id; //int
    const SESSION_USERID = 'user_id';

    function __construct(DbAdapter $DbAdapter)
    {
        $this->db = $DbAdapter->getConnection();
        //$this->id = $id;
    }

    //sessions id 00generate_hash_map00
        //setcookie() 00hash_map00
        //session:00generate_hash_map00 data1 data2..

    /**
     * SESSION_userid:xxxxcookiehash00000 [k1 v1] [k2 v2] 
     */
    function start($user_id)
    {
        $hash = uniqId();

        $this->db->select(self::DB_SELECTED);

        if($this->db->hget(self::SESSION_DB.$hash, $user_id)) {
            $this->db->del(self::SESSION_DB.$hash);
        }
        $r = $this->db->hset(self::SESSION_DB.$hash, self::SESSION_USERID, $user_id);

        setcookie(self::COOKIE_NAME, $hash, time()+self::COOKIE_TIME, '/');
        //setcookie(self::COOKIE_NAME.':id', $this->id);

        //$name,
      /*  $value = "",
        $expire = 0,
        $path = "",
        $domain = "",
        $secure = false,
        $httponly = false*/
        
        return $r?$hash:false;
    }

    function isValid(): bool
    {
        $this->db->select(self::DB_SELECTED);
        if(isset($_COOKIE[self::COOKIE_NAME])) {
            $cookie_id = $_COOKIE[self::COOKIE_NAME];
            
            if($r=$this->db->hget(self::SESSION_DB.$cookie_id, self::SESSION_USERID)) {
                return true;
            }
        }
        return false;
    }

    function set($k,$v): bool
    {
        $this->db->select(self::DB_SELECTED);
        $cookie_id = $_COOKIE[self::COOKIE_NAME];
        if($this->isValid())  {
            $this->db->hset(self::SESSION_DB.$cookie_id, $k, $v);
            return true;
        }
        return false;
    }

    function get($k)
    {
        $this->db->select(self::DB_SELECTED);
        $cookie_id = $_COOKIE[self::COOKIE_NAME];
        if($this->isValid())  {
            return $this->db->hget(self::SESSION_DB.$cookie_id, $k);
        }
       
    }

    //delete session:00generate_hash_map00
        //delete sessions id
    function close()
    {
        $this->db->select(self::DB_SELECTED);
        $cookie_id = $_COOKIE[self::COOKIE_NAME];
        if($this->db->hget(self::SESSION_DB.$cookie_id, self::SESSION_USERID)) {
            $this->db->del(self::SESSION_DB.$cookie_id);
        }
        
        setcookie(self::COOKIE_NAME, '', time()-3600, '/');
        return true;
    }
}
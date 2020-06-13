<?php 

namespace App\Models;


use App\Adapters\DbAdapter;

class User 
{
    protected $db;
    
    protected $id;
    public $login;

    /**
     * When read()
     * keep 'now' value before update()
     */
    protected $current=[];

    /**
     * DATABASE user:0
     * DATABASE follower:2
     * DATABASE session:3
     * DATABASE message:4
     */
    const DB_SELECTED = 0;
    const DB_SELECTED_F = 2;

    /**
     * Tables 
     * USER_INC incrementable_id
     * USER:1000 k v k2 v2 k3 v3
     * USERS login id
     */
    const DB_INC_IDS="user_incr_id";
    const DB_USER="user:"; #user:LOGIN for connection
    const DB_USERS_LOGIN_ID="users";
    const DB_FOLLOWERS="follower:"; #FOLLOWERS "user" 'follow1' 'follow2' 'follow3' ...

    //USER
    const USER_ID="id";
    const USER_LOGIN="login";
    

    function __construct(DbAdapter $DbAdapter)
    {
        $this->db = $DbAdapter->getConnection();
        $this->db->select(self::DB_SELECTED);
    }

    function flush()
    {
        $this->db->flushAll();
    }

    function create(): bool
    {
        //id
        $this->id = $this->db->incr(self::DB_INC_IDS);
        
        //user
        $r=$this->db->hmset( self::DB_USER."{$this->id}", [
            self::USER_LOGIN => $this->login
        ]);

        //users list
        $this->db->hset( self::DB_USERS_LOGIN_ID, $this->login, $this->id );

        $this->db->expire(self::DB_USER, 3600*24);
        $this->db->expire(self::DB_USERS_LOGIN_ID, 3600*24);
        
        return $r?true:false;
    }

    function getId()
    {
        return $this->id;
    }

    function update(): bool
    {
        if(!$this->id) {
            throw new \Exception("User {$this->id} inexistant, use READ before"); 
        }

        //user
        $r=$this->db->hmset( self::DB_USER."{$this->id}", [
            self::USER_LOGIN => $this->login
        ]);

        //users
        $this->db->hdel( self::DB_USERS_LOGIN_ID, $this->current[self::USER_LOGIN] );
        $this->db->hset( self::DB_USERS_LOGIN_ID, $this->login, $this->id );

        $this->db->expire(self::DB_USERS_LOGIN_ID, 3600*24);
        
        return $r?true:false;
    }

    function getLastInsertId(): int
    {
        return $this->db->get(self::DB_INC_IDS);
    }

    function existsLogin(string $login)
    {
        return $this->db->hget(self::DB_USERS_LOGIN_ID, $login)?true:false;
    }

    function delete(): bool
    {
        if(!$this->id) {
            throw new \Exception("User {$this->id} inexistant, use READ before"); 
        }
        
        $this->db->hdel( self::DB_USERS_LOGIN_ID, $this->login );
        return $this->db->del(self::DB_USER."{$this->id}")?true:false;
    }

    function readFromLogin(string $login)
    {
        $id = $this->db->hget(self::DB_USERS_LOGIN_ID, $login);
        
        if($id) {
            return $this->read($id);
        }
    }

    /**
     * read USER
     * @return [k1 v1 k2 v2 k3 v3]
     */
    function read(int $id): ?array
    {
        $this->id = $id;
        $r=$this->db->hgetall( self::DB_USER."{$id}" );

        if(!array_key_exists(self::USER_LOGIN, $r)) {
            return null;
        }
        $this->login = $r[ self::USER_LOGIN ];

        $this->current = [
            self::USER_LOGIN => $this->login
        ];
        
        return $r?:false;
    }

    function readAll(): array //of array
    {
        $r=$this->db->hgetall( self::DB_USERS_LOGIN_ID );
        return $r?:[];
    }

    public function follow(int $user_id): bool
    {
        $this->db->select(self::DB_SELECTED_F);

        // insert user in Zset list
        if($this->db->zadd(self::DB_FOLLOWERS.$this->id, time(), $user_id)) {
            $this->db->expire(self::DB_FOLLOWERS.$this->id, 3600*24);
            return true;
        }
        return false;
    }

    public function get_followers(): array //of id
    {
        $this->db->select(self::DB_SELECTED_F);
        $r = $this->db->zrange(self::DB_FOLLOWERS.$this->id, -10, 10);
        return $r;
    }

    public function unfollow(int $user_id)
    {
        // TODO: write logic here
        $this->db->select(self::DB_SELECTED_F);
        if($this->db->zrem(self::DB_FOLLOWERS.$this->id, $user_id)) {
            return true;
        }
        return false;
    }
}
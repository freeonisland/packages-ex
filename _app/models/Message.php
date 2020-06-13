<?php 

namespace App\Models;

use App\Adapters\DbAdapter;

/**
 * Functions:
 * - create msg, set id in every lists of followers
 */
class Message 
{
    protected $db;
    
    protected $id;
    public $user;
    public $msg;
    

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
    const DB_SELECTED = 4;

    /**
     * TAbles
     * INCR_ID id
     * MSG:id User "id" Text "messageenregistré"
     * MSGS 'user' 'id'
     */
    const DB_INC_IDS="post_incr_id"; //(key)
    const DB_MSG="post:"; //(hash) post:1000 user "user_id" msg "msg" time "time"
    const DB_MSGS="posts"; //timeline all posts (list) POSTS "msg_id" "msg_id2"...

    const DB_MSG_USER='user_posts:'; //(list) USER_POSTS:id_user msg1 msg2 msg3...
    const DB_MSG_FOLLOWER="fpost:"; //(list) FPOST:user_id msg_id1 msg_id2 msg_id3...
    
    //MSG keys
    const MSG_ID="id";
    const MSG_TEXT="text";
    const MSG_USER="user";
    const MSG_TIME="time";

    function __construct(DbAdapter $DbAdapter)
    {
        $this->db = $DbAdapter->getConnection();
        $this->db->select(self::DB_SELECTED);
    }

    function flush()
    {
        $this->db->flushDb(self::DB_SELECTED);
    }

    /**
     * @require 
     *  user
     *  msg
     */
    function create(): bool
    {
        $this->db->select(self::DB_SELECTED);

        //id
        $this->id = $this->db->incr(self::DB_INC_IDS);

        if(!$this->msg || !$this->user) { //user_id
            throw new \Exception('No text message or user');
        }

        //msg
        $r=$this->db->hmset( self::DB_MSG.$this->id, [
            self::MSG_ID => $this->id,
            self::MSG_TEXT => $this->msg,
            self::MSG_USER => $this->user,
            self::MSG_TIME => time()
        ]);

        //user own posts
        $this->db->lpush(self::DB_MSG_USER.$this->user, $this->id);
        
        //add to timeline
        $this->db->lpush(self::DB_MSGS, $this->id);

        $this->db->expire(self::DB_MSG, 3600*24);
        $this->db->expire(self::DB_MSG_USER, 3600*24);
        $this->db->expire(self::DB_MSGS, 3600*24);

        return $r?true:false;
    }

    /**
     * Insert pour chaque followers
     * follow1 [id1, id2, id3],
     * follow2 [id1, id2, id3]
     */
    function insertToFollowersLists(array $followers_id): bool
    {
        $this->db->select(self::DB_SELECTED);

        foreach($followers_id as $follower_id) {
            $this->db->lpush(self::DB_MSG_FOLLOWER.$follower_id, $this->id);
        }
        return true;
    }

    function getTimelineMessages()
    {
        $this->db->select(self::DB_SELECTED);
        
        $list=[];
        $messages_id = $this->db->lrange(self::DB_MSGS, -10, 1000);
        foreach($messages_id as $m_id) {
            $list[] = $this->db->hgetall(self::DB_MSG.$m_id);
        }
        return $list;
    }

    /**
     * get timeline (of followed) messages for a user
     * 1) get timeline messages_ids
     * 2) get datas for each message_id
     */
    function getMessagesList()
    {
        $this->db->select(self::DB_SELECTED);
        //echo self::DB_MSG_FOLLOWER.$this->user;
        $list=[];
        $messages_id = $this->db->lrange(self::DB_MSG_FOLLOWER.$this->user, 0, 1000);
        
        foreach($messages_id as $message_id) {
            $list[] = $this->db->hgetall(self::DB_MSG.$message_id);
        }

        return $list;
    }

    /**
     * Get messages createds by a user
     */
    function getPostedMessages(): array
    {
        $this->db->select(self::DB_SELECTED);
        $messages = $this->db->lrange(self::DB_MSG_USER.$this->user, 0, 10);

        $list=[];
        foreach($messages as $message_id) {
            $list[] = $this->db->hgetall(self::DB_MSG.$message_id);
        }
        
        return $list;
    }

    function getId()
    {
        return $this->id;
    }

    function getLastInsertId(): int
    {
        $this->db->select(self::DB_SELECTED);

        return $this->db->get(self::DB_INC_IDS);
    }

    /**
     * Read MSG
     * @return [k1 v1 k2 v2 k3 v3]
     */
    function read(int $id): ?array
    {
        $this->db->select(self::DB_SELECTED);
        $r=$this->db->hgetall( self::DB_MSG.$id );

        if(array_key_exists( self::MSG_ID, $r)) {
            $this->id = $r[ self::MSG_ID ];
        } else {
            throw new \OutOfBoundsException('id doesnt exists to read');
        }
        
        return $r?:null;
    }

    /**
     * Read MSG
     */
    function delete(): bool
    {
        if(!$this->id) {
            throw new \OutOfRangeException("id not defined to delete");
        }
        $this->db->select(self::DB_SELECTED);
        
        $r=$this->db->del( self::DB_MSG.$this->id );

        return $r?true:false;
    }
}
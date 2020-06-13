<?php
/*
 * This file is part of SocketController.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 App\Controllers 
 */

namespace App\Controllers;

use App\Models\Message;
use App\Managers\RedisManager;
use App\Managers\SessionManager;
use App\Models\User;

class MessageController  extends ControllerBase
{ 
    function createAction() 
    {
        $msg = $this->message;
        $msg->user = $this->session->get( SessionManager::SESSION_USERID );
        $msg->msg = $this->get('msg');
        $msg->create();

        $this->user->read( $this->session->get( SessionManager::SESSION_USERID ) );
        $followers_id = $this->user->get_followers();

        $msg->insertToFollowersLists($followers_id);

        $this->redirect();
    }
}
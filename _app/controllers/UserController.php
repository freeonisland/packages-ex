<?php
/*
 * This file is part of UserController.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 App\Controllers 
 */
 
namespace App\Controllers;

use App\Managers\RedisManager;
use App\Managers\SessionManager;
use App\Models\User;

class UserController extends ControllerBase
{
    function createAction()
    {
        $this->user->login = $this->get('login');
        $this->user->create();
        $this->redirect();
    }

    function deleteAction()
    {
        $id = $this->get('id');
        $this->user->read($id);
        $this->user->delete();
        $this->redirect();
    }

    function loginAction()
    {
        
        if(!$this->user->existsLogin($this->get('login'))) {
            throw new \Exception('User doesnt exists');
            return;
        }
        
        $this->user->readFromLogin($this->get('login'));
        $id = $this->user->getId();
        
        
        $this->session->start($id);
        
        $this->redirect();
    }

    function logoutAction()
    {
        $this->session->close();
        $this->redirect();
    }

    function followAction()
    {
        $this->user->read( $this->session->get($this->session::SESSION_USERID) );
        $this->user->follow( $this->get('id') );

        $this->redirect();
    }

    function unfollowAction()
    {
        
        $this->user->read( $this->session->get($this->session::SESSION_USERID) );
        $this->user->unfollow( $this->get('id') );

        $this->redirect();
    }
}
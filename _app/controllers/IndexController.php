<?php
declare(strict_types=1);

namespace App\Controllers;

class IndexController extends ControllerBase
{
    public function indexAction($ldap=null)
    {

        echo 'bla';
        /*$this->view->user = $this->user;
        $this->view->users = $this->user->readAll();

        $this->view->isLogged=false;
        $this->view->user_id = null;
        $this->view->followers=[];
        $this->view->user_messages=[];
        $this->view->followed_messages=[];
        $this->view->all_messages=[];

        if($this->session->isValid()) {
            $user_id = (int)$this->session->get( \App\Managers\SessionManager::SESSION_USERID );
            $this->user->read( $user_id );
            $this->message->user = $user_id;
            
            $this->view->isLogged = true;
            $this->view->user_messages = $this->message->getPostedMessages();
            $this->view->followers = $this->user->get_followers();

            $this->view->followed_messages = $this->message->getMessagesList( )?:[];

            $this->view->all_messages = $this->message->getTimelineMessages();

            $this->view->user_id = $this->user->getId();
        }*/
    }

    private function _infos()
    {
        /*$this->session->start(); 
        if(!$cache = $this->redis->getPageCache()) {
            ob_start();
        } else {
            echo 'CACHE<br/>';
            echo $cache;
            return;
        }

        v($_SERVER['HOSTNAME']);
        v($_SERVER['HTTP_COOKIE']);
        
        v($_COOKIE);
        //session_regenerate_id();
        v($_SESSION);

        if(!$this->redis->getPageCache()) {
            $this->redis->setPageCache($r=ob_get_contents());
            ob_end_clean();
            echo serialize($r);
        }*/
        
        /*
         * session.save_handler = redis
session.save_path = "tcp://localhost:6379"
         */
    }
    
}


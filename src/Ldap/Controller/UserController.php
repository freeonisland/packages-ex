<?php

namespace Ldap\Controller;

use App\Controller\AbstractController;
use Ldap\Entity\User;

class UserController extends AbstractController
{
    /**
     * 
     */
    public function listAction()
    {
        $users = [
            ['id'=>0, 'name'=>'michel'],
            ['id'=>1, 'name'=>'alphonse'],
            ['id'=>2, 'name'=>'bernard']
        ];
        return ['users' => $users ];
    }

    /**
     * 
     */
    public function createAction()
    {
        $user = new User; 
        if($this->post) {
            // Create data ...

            //s($this->post);
            //$user->name = $this->post['user_name'];
        }

        return [
            'user' => get_object_vars($user)
        ]; 
    }

    /**
     * 
     */
    public function updateAction(string $userId)
    {
        $user = new User; 
        $user->setId($userId);
        $user->name = 'john';
        $user->surname = 'jy';
        
        if(count($this->post)) {
            // Update data ...
            //s($this->post);
            
            $user->name = $this->post['user_name'];
            $user->surname = $this->post['user_surname'];
            $user->phone = $this->post['user_phone'];
        }

        return [
            'user' => $user
        ]; 
    }

    /**
     * 
     */
    public function viewAction(string $userId)
    {
        $user = new User; 
        $user->setId($userId);
        $user->name = 'john';
        $user->surname = 'jy';

        return [
            'user' => $user
        ]; 
    }

    /**
     * 
     */
    public function deleteAction($userId)
    {
        $user = new User; 
        $user->setId($userId);
        $user->name = 'john';
        $user->surname = 'jy';
        
        if(count($this->post)) {
            // Delete data ...
            //s($this->post);
            echo 'deleted';
        }

        return [
            'user' => $user
        ]; 
    }
}
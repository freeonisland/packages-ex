<?php

namespace Ldap\Controller;

use App\Controller\AbstractController;
use Ldap\Entity\User;
use Ldap\Entity\LaminasRepository;

class UserController extends AbstractController
{
    public function schemas(): array
    {
        $lm = $this->getModule('LaminasManager');
        $s = $lm->search( 
            'objectClass=subSchema',
            'cn=Subschema',
            \Laminas\Ldap\Ldap::SEARCH_SCOPE_BASE, 
            ['objectclasses']
        );
        $s = $s ? $s[0]['objectclasses'] : [];
        $r=[];
        array_walk($s,function($v,$k) use (&$r) {
           //$s[$k] =
           preg_match("/NAME '(\w*)'/",$v,$m);
           if(isset($m[1])) {
               $r[$m[1]] = $v;
           }
        });
        
        return $r;
    }

    /**
     * 
     */
    public function listAction()
    {
        $lm = $this->getModule('LaminasManager');
        $schemas = $this->schemas();

        return [
            'users' => $res??[]
        ];
    }

    /**
     * 
     */
    public function createAction()
    {
        $user = new User; 
        $lm = $this->getModule('LaminasManager');
        
        if($this->post) {
            // Create data ...
            $lm->add('person', [
                'cn' => $this->post['user_name'],
                'sn' => $this->post['user_surname']
            ]);
            //s($this->post);
        //     'user_name' => string (3) "aze"
        // 'user_surname' => string (6) "azesur"
        // 'user_phone' => string (7) "0147852"
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
        $lm=$this->getModule('LaminasManager');
        $s="(&(objectClass=person)(cn={$userId}))";
        $user=$lm->search($s);
        
        
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
        $lm = $this->getModule('LaminasManager');
        $user=$lm->search('(&(cn=aqwzxs)(objectClass=person))');

        return [
            'user' => $user?$user[0]:null
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

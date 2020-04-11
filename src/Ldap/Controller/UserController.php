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
        $res = $lm->search('objectClass=person');

        return [
            'users' => $res??[]
        ];
    }

    /**
     * 
     */
    public function createAction()
    {   
        $lm = $this->getModule('LaminasManager');
        
        if($this->post) {
            // Create data ...
            $lm->add('person', [
                'cn' => $this->post['cn'],
                'sn' => $this->post['sn']
            ]);
        }

        return [
            'user' => [
                'cn'=>[''],
                'sn'=>['']
            ]
        ]; 
    }

    public function updateAction(string $userId)
    {
        $lm=$this->getModule('LaminasManager');
        $s="(&(objectClass=person)(cn={$userId}))";
        $user=$lm->search($s);
        
        if($this->post) {
            // Update data ...
            $lm->update('person', $this->post['uid'], [
                'cn' => $this->post['cn'],
                'sn' => $this->post['sn']
            ]);
        }

        return [
            'user' => $user[0]
        ]; 
    }

    /**
     * 
     */
    public function viewAction(string $userId)
    {
        $lm = $this->getModule('LaminasManager');
        $user=$lm->search("(&(cn={$userId})(objectClass=person))");

        return [
            'user' => $user?$user[0]:null
        ]; 
    }

    /**
     * 
     */
    public function deleteAction(string $userId)
    {
        $lm = $this->getModule('LaminasManager');
        $user=$lm->get($userId);
             
        
        if(count($this->post)) {
            // Delete data ...
            s($this->post);
            if('yes'===$this->post['confirm']) {
                $lm->delete($userId);
                \Flight::redirect('/ldap/user/list');
                die();
            }
        }

        return [
            'user' => $user[0]
        ]; 
    }
}

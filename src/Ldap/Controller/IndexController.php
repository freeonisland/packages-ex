<?php

namespace Ldap\Controller;

use App\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * 
     */
    public function indexAction()
    {
        //$this->getParam('LDAP_SERVER');

        $ldap_conn = ldap_connect('ldap://docker-ldap');
        
        $ldap_dn = "cn=admin,dc=my-company,dc=com";
        $ldap_pass = "JonSn0w";

        try {
            if ($d=ldap_bind_ext($ldap_conn, $ldap_dn, $ldap_pass, [['oid' => LDAP_CONTROL_PASSWORDPOLICYREQUEST]] )) {
                s($d);
                echo 'Ldap connected';
            }
        } catch(\Exception $e) { echo "EXCEPTION: ".$e->getMessage(); }
    }
}
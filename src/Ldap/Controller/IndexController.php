<?php

namespace Ldap\Controller;

class IndexController
{
    /**
     * 
     */
    public function indexAction()
    {
        echo 'ldap';
        $ldap_conn = ldap_connect('ldap://docker-ldap');

        
        $ldap_dn = "cn=admin,dc=example,dc=org";
        $ldap_pass = "admin";

        if ($d=ldap_bind($ldap_conn, $ldap_dn, $ldap_pass)) {
            s($d);
        }
    }
}
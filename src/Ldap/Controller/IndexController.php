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
        $ldap_conn = ldap_connect('ldap://' . $this->getParam('LDAP_SERVER'));
        $ldap_dn = $this->getParam('LDAP_DN');
        $ldap_pass = $this->getParam('LDAP_PASSWORD');

        try {
            if ($d=ldap_bind_ext($ldap_conn, $ldap_dn, $ldap_pass, [['oid' => LDAP_CONTROL_PASSWORDPOLICYREQUEST]] )) {
                echo 'LDAP connected';
                s($d);
            } else {
                echo "Can't connect to LDAP";
            }
        } catch(\ErrorException $e) { echo "LDAP EXCEPTION: ".$e->getMessage(); }
    }
}
<?php declare(strict_types=1);

namespace Ldap\Manager;

class SimpleManager
{
    private $ldapServer;
    private $ldapDn;
    private $ldapPass;

    public function __construct($ldap_server, $ldap_dn, $ldap_pass)
    {
        $this->ldapServer = $ldap_server;
        $this->ldapDn = $ldap_dn;
        $this->ldapPass = $ldap_pass;
    }

    public function connect()
    {
        $ldap_conn = ldap_connect('ldap://' . $this->ldapServer);

        try {
            if ($d=ldap_bind_ext($ldap_conn, $this->ldapDn, $this->ldapPass, [['oid' => LDAP_CONTROL_PASSWORDPOLICYREQUEST]] )) {
                echo 'LDAP connected.';
                s($d);
            } else {
                echo "Can't connect to LDAP";
            }
        } catch(\ErrorException $e) { echo "LDAP EXCEPTION: ".$e->getMessage(); }
    }
}
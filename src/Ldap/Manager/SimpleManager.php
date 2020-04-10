<?php declare(strict_types=1);

namespace Ldap\Manager;

class SimpleManager extends AbstractLdapManager implements LdapManagerInterface
{
    public function connect(): bool
    {
        $ldap_conn = ldap_connect('ldap://' . $this->ldapServer);

        try {
            if ($d=ldap_bind_ext($ldap_conn, $this->ldapDn, $this->ldapPass, [['oid' => LDAP_CONTROL_PASSWORDPOLICYREQUEST]] )) {
                //echo 'Simple-LDAP connected.';
                
                return true;
            } else {
                echo "Can't connect to Simple-LDAP";
            }
        } catch(\ErrorException $e) { echo "LDAP EXCEPTION: ".$e->getMessage(); }
        return false;
    }
}
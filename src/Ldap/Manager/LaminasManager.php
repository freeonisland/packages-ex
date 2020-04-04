<?php declare(strict_types=1);

namespace Ldap\Manager;

use Laminas\Ldap\Ldap;

class LaminasManager extends AbstractLdapManager implements LdapManagerInterface
{
    /*
     * $options = [
        'host'              => 's0.foo.net',
        'username'          => 'CN=user1,DC=foo,DC=net',
        'password'          => 'pass1',
        'bindRequiresDn'    => true,
        'accountDomainName' => 'foo.net',
        'baseDn'            => 'OU=Sales,DC=foo,DC=net',
    ];
     */
    function connect(): bool
    {
        $options = [
            'host'              => $this->ldapServer,
            'username'          => $this->ldapDn,
            'password'          => $this->ldapPass,
            'bindRequiresDn'    => true,
            'accountDomainName' => 'my-company.com',
            'baseDn'            => 'cn=Sales,dc=my-company,dc=com',
        ];
        
        $ldap = new Ldap($options);
        //$acctname = $ldap->getCanonicalAccountName('abaker', Ldap::ACCTNAME_FORM_DN);
        //echo "$acctname\n";
        try {
            if ($ldap) {
                echo 'LDAP Laminas connected.';
                s($ldap);
                return true;
            } else {
                echo "Can't connect to LDAP Laminas";
            }
        } catch(\ErrorException $e) { echo "LDAP EXCEPTION: ".$e->getMessage(); }
        return false;
    }
}
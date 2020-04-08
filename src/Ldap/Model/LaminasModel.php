<?php declare(strict_types=1);

namespace Ldap\Model;

use Laminas\Ldap\Ldap;
use Ldap\Manager\LaminasManager;

class LaminasModel
{
    /**
     * @var LdapManager
     */
    private $lm;

    /**
     * Laminas Ldap connector
     */
    private $ldap;

    /**
     * Base DN
     * @todo from configfile
     */
    private $basedn;

    /**
     * WEB AUTHENTICATION
     * 
     *      Attribute Type:
     * account (userid), description, host
     * applicationEntity (cn, presentationAddress), description, l, o, ou, seeAlso
     * groupOfNames (cn, member), businessCategory, description, o, ou, owner, seeAlso
     * ipHost (cn, ipHostNumber), description, l, manager
     * mailAccount (mail)
     * organization (o)
     * person: (cn, sn), description, seeAlso, telephoneNumber, userPassword
     */

    public function __construct()
    {
        $this->basedn = 'dc=my-company,dc=com';
    }

    /**
     * try multiple function of ldap (search, insert, etc...)
     */
    public function runFunctions(LaminasManager $laminasManager)
    {
        $this->lm = $laminasManager;
        //echo 'ertre.'.$ldap->getBaseNode();
        //s($this->lm);

        $this->ldap = $this->lm->getLdap();

        $this->search();
        $this->insert();
        $this->update();
    }

    /** 
     * Search into 
     */
    private function search()
    {
        $s=$this->ldap->search('objectClass=*', $this->basedn, Ldap::SEARCH_SCOPE_SUB);
        //s($this->ldap->getEntry());
        //s(get_class_methods($this->ldap));
    }

    
    private function insert()
    {
        $s=$this->ldap->searchEntries(
            '(&(objectClass=person)(cn=Alpha))', 
            $this->basedn, 
            Ldap::SEARCH_SCOPE_SUB,
        ['*']);

        /**
         * add
         */
        try {
            $this->ldap->add('cn=Alpha,'.$this->basedn, [
                'objectClass' => 'person',
                'cn' => 'Alpha',
                'sn' => 'Alpha'
            ]);
            
        } catch(\Exception $e) { echo 'EXCEPTION:'.$e->getMessage().'<br/>'; } 
        //s($r);
    }

    private function update()
    {
        $s=$this->ldap->search('objectClass=*', $this->basedn, Ldap::SEARCH_SCOPE_SUB);
        //s($this->ldap->getEntry());
        //s(get_class_methods($this->ldap));
    }
}
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
     * try multiple function of ldap (search, insert, etc...)
     */
    public function runFunctions(LaminasManager $laminasManager)
    {
        $this->lm = $laminasManager;
        //echo 'ertre.'.$ldap->getBaseNode();
        //s($this->lm);

        $this->ldap = $this->lm->getLdap();

        $this->search();
        $this->insertUpdate();
    }

    /*
search(
    string|Filter\AbstractFilter $filter,
    string|Dn $basedn,
    int $scope,
    array $attributes,
    string $sort,
    string $collectionClass,
    int $sizelimit,
    int $timelimit
) : Collection


    $filter: The filter string to be used in the search, e.g. (objectClass=posixAccount).
    $basedn: The search base for the search. If omitted or null, the baseDn from the connection and binding parameters is used.
    $scope: The search scope:
        Ldap::SEARCH_SCOPE_SUB searches the complete subtree including the $baseDn node. This is the default value.
        Ldap::SEARCH_SCOPE_ONE restricts search to one level below $baseDn.
        Ldap::SEARCH_SCOPE_BASE restricts search to the $baseDn itself; this can be used to efficiently retrieve a single entry by its DN.
    $attributes: Specifies the attributes contained in the returned entries. To include all possible attributes (ACL restrictions can disallow certain attribute to be retrieved by a given user), pass either an empty array ([]) or an array containing a wildcard (['*']) to the method. On some LDAP servers, you can retrieve special internal attributes by passing ['*', '+'] to the method.
    $sort: If given, the result collection will be sorted according to the attribute $sort. Results can only be sorted after one single attribute as this parameter uses the ext/ldap function ldap_sort().
    $collectionClass: If given, the result will be wrapped in an object of type $collectionClass. By default, an object of type Laminas\Ldap\Collection will be returned. The custom class must extend Laminas\Ldap\Collection, and will be passed a Laminas\Ldap\Collection\Iterator\Default on instantiation.
    $sizelimit: Enables you to limit the count of entries fetched. Setting this to 0 means no limit.
    $timelimit: Sets the maximum number of seconds to spend on the search. Setting this to 0 means no limit.

    */
    private function search()
    {
        $filter = 'objectClass=*';

        $s=$this->ldap->search($filter, 'dc=my-company,dc=com', Ldap::SEARCH_SCOPE_SUB);
        //s($s);
    }

    private function insertUpdate()
    {
        /**
         * add
         */
        try {
            $this->ldap->add('cn=Alpha,dc=my-company,dc=com', [
                'objectClass' => 'person',
                'cn' => 'Alpha',
                'sn' => 'Alpha'
            ]);
        } catch(\Exception $e) { echo 'EXCEPTION:'.$e->getMessage().'<br/>'; } 
        //s($r);
    }
}
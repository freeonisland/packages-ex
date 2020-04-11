<?php

namespace Ldap\Controller;

use App\Controller\AbstractController;
use Ldap\Entity\User;
use Ldap\Entity\LaminasRepository;

class UserController extends AbstractController
{
    public function schemas()
    {
        
        $ldapconn = ldap_connect("ldap://ldap-server")
        or die("Impossible de se connecter au serveur LDAP.");
        $ld=$ldapconn;
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);

        if ($ldapconn) {

            // Connexion au serveur LDAP
            $ldapbind = ldap_bind($ldapconn, 'cn=admin,dc=my-company,dc=com', 'JonSn0w');
            // Vérification de l'authentification
            if ($ldapbind) {
                echo "Connexion LDAP réussie...";
            } else {
                echo "Connexion LDAP échouée...";
            }
            //s($ldapbind);
            $search = ldap_read($ldapconn, "", "objectclass=*", array('*', 'subschemasubentry'));
            
            $entries = ldap_get_entries($ldapconn, $search);
            s($entries);
            $schemadn = $entries[0]["subschemasubentry"][0];

            $entries = ldap_get_entries($ld, $search);
  $schemadn = $entries[0]["subschemasubentry"][0];

  print "Searching ". $schemadn . "<br/>";

  // Read all objectclass, attributetype from subschema
  $schsearch = ldap_read($ld, $schemadn, "objectClass=subSchema", array('objectclasses', 'attributetypes'));
  $schentries = ldap_get_entries($ld, $schsearch);
  s($schentries);
        } 
//        $ldap = $lm->getLdap();
  //      $s = $lm->search('objectClass=*');


        //s($s);
        /*$search = ldap_read($ld, "", "objectclass=*", array('*', 'subschemasubentry'));
        $entries = ldap_get_entries($ld, $search);
        $schemadn = $entries[0]["subschemasubentry"][0];*/
    }

    /**
     * 
     */
    public function listAction()
    {
        $lm = $this->getModule('LaminasManager');
        $res = $lm->search('objectClass=person');

      
        

        $this->schemas();
        /*$s=$ldap->search(
            'subschemaSubentry',
            'dc=my-company,dc=com',
            \Laminas\Ldap\Ldap::SEARCH_SCOPE_BASE);
*/
        //$s=exec("ldapsearch -H ldap://ldap-server -x -s base -b 'cn=subschema' objectclasses");
        //s($s);

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


/*
GET ALL SUBSCHEMAS
 *  $search = ldap_read($ld, "", "objectclass=*", array('*', 'subschemasubentry'));
  $entries = ldap_get_entries($ld, $search);
  $schemadn = $entries[0]["subschemasubentry"][0];

  print "Searching ". $schemadn . "<br/>";

  // Read all objectclass, attributetype from subschema
  $schsearch = ldap_read($ld, $schemadn, "objectClass=subSchema", array('objectclasses', 'attributetypes'));
  $schentries = ldap_get_entries($ld, $schsearch);

  $count = $schentries[0]["attributetypes"]["count"];

  print "Printing all attribute types <br/>";
  for ($i=0; $i<$count; $i++)
     print $schentries[0]["attributetypes"][$i] . "<br/>";


  $count = $schentries[0]["objectclasses"]["count"];

  print "Printing all objectclasses <br/>";
  for ($i=0; $i<$count; $i++)
     print $schentries[0]["objectclasses"][$i] . "<br/>";
 */
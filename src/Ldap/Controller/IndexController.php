<?php

namespace Ldap\Controller;

use App\Controller\AbstractController;
use Ldap\Manager\SimpleManager;
use Ldap\Manager\LaminasManager;
use Ldap\Model\LaminasModel;

class IndexController extends AbstractController
{
    /**
     * 
     */
    public function indexAction()
    {
        $simpleManager = new SimpleManager($this->getParam('LDAP_SERVER'), $this->getParam('LDAP_DN'), $this->getParam('LDAP_PASSWORD'));
        //$simpleManager->connect();

        $laminasManager = new LaminasManager($this->getParam('LDAP_SERVER'), $this->getParam('LDAP_DN'), $this->getParam('LDAP_PASSWORD'));
        $laminasManager->connect();
        $laminasModel = new LaminasModel;
        $laminasModel->runFunctions($laminasManager);
    }

}
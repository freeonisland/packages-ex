<?php

namespace App\Controller;

use App\Controller\AbstractController;

class IndexController extends AbstractController
{
    /**
     * 
     */
    public function indexAction()
    {
        echo '<a href="/ldap">Ldap</a><br/>';
        echo '<a href="/oauth">Oauth</a><br/>';
    }
}
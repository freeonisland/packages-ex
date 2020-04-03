<?php

namespace Oauth\Controller;

use Oauth\Provider\GithubProvider;

class ClientController
{
    public function providerAction()
    {
        (new GithubProvider)->provide();
    }
}
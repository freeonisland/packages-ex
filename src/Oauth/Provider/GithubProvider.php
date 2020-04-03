<?php

namespace Oauth\Provider;

use GuzzleHttp\Client;

class GithubProvider
{
    public function provide()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://github.com/freeonisland/oauth/authorize', [
            'client_id' => ['user', 'pass']
        ]);
        echo $res->getStatusCode();
        // "200"
        echo $res->getHeader('content-type')[0];
        // 'application/json; charset=utf8'
        echo $res->getBody();
    }
}
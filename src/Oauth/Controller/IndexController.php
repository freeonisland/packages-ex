<?php

namespace Oauth\Controller;

class IndexController
{
    function __construct()
    {

    }

    function microAction($name='e', $pignon='r')
    {
        s('hello');
        s($name);
        s($pignon);
    }
}
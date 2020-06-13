<?php

namespace App\Home\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class IndexController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('home/index.html.twig', [
            
        ]);
    }
}

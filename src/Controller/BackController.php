<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BackController extends AbstractController
{
    /**
     * @Route("/login", name="Login")
     */
    public function Login()
    {
        return $this->render('back/Login.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }

    /**
     * @Route("/test", name="test")
     */
    public function Test()
    {
        return $this->render('back/test.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
}

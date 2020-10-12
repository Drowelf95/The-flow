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
     * @Route("/splashPage", name="splashPage")
     */
    public function splashPage()
    {
        return $this->render('back/splashPage.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }

    /**
     * @Route("/segmentView", name="segmentView")
     */
    public function segmentView()
    {
        return $this->render('back/segmentView.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
        
    /**
     * @Route("/segmentAdd", name="segmentAdd")
     */
    public function segmentAdd()
    {
        return $this->render('back/segmentAdd.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }

    /**
     * @Route("/segmentEdit", name="segmentEdit")
     */
    public function segmentEdit()
    {
        return $this->render('back/segmentEdit.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }

        /**
     * @Route("/segmentTrash", name="segmentTrash")
     */
    public function segmentTrash()
    {
        return $this->render('back/segmentTrash.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
    
    /**
     * @Route("/profil", name="Profil")
     */
    public function profil()
    {
        return $this->render('back/Profil.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }
}
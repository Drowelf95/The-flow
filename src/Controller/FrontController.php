<?php

namespace App\Controller;

use App\Repository\SegmentsRepository;
use App\Repository\SplashRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FrontController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(SplashRepository $repo, SegmentsRepository $repo2)
    {

        $splash = $repo->findAll();

        $segments = $repo2->findBy(['deleted'=>false]);

        return $this->render('front/home.html.twig', [
            'controller_name' => 'FrontController',
            'splash' => $splash,
            'segments' => $segments
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilType;

use App\Repository\SplashRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/profil/{id}", name="Profil")
     */
    public function profil(Profil $profil = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        if(!$profil) 
        {
            $profil = new Profil(); 
        }

        $form = $this->createForm(ProfilType::class, $profil);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $profil->setCreatedAt(new \DateTime());

            $hash = $encoder->encodePassword($profil, $profil->getPassword());
            $profil->setPassword($hash);

            $manager->persist($profil);
            $manager->flush();

            return $this->redirectToRoute('segmentView');
        }

        return $this->render('security/Profil.html.twig', [
            'controller_name' => 'BackController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="Login")
     */
    public function Login(SplashRepository $repo)
    {

        $splash = $repo->findAll();
        
        return $this->render('security/Login.html.twig', [
            'controller_name' => 'BackController',
            'splash' => $splash
        ]);
    }

    /**
     * @Route("/logout", name="LogOut")
     */
    Public function logout() {}
}

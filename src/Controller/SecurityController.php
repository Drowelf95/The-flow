<?php

namespace App\Controller;

use App\Entity\Profil;
use App\Form\ProfilType;

use App\Repository\SplashRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/profile/{id}", name="Profile")
     */
    public function profil(Profil $profil = null, Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder)
    {
        if(!$profil) 
        {
            $profil = new Profil(); 
        }

        $oldPass = $profil->getPassword();

        $form = $this->createForm(ProfilType::class, $profil);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $newPass = $form["new_password"]->getData();

            $profil->setCreatedAt(new \DateTime());

            $hash = $encoder->encodePassword($profil, $newPass);
            $profil->setPassword($hash);

            $manager->persist($profil);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your informations have been updeated.'
            );

            return $this->redirect($request->getUri());
        }

        return $this->render('security/profile.html.twig', [
            'controller_name' => 'BackController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="Login")
     */
    public function Login(SplashRepository $repo, AuthenticationUtils $authenticationUtils)
    {

        $splash = $repo->findAll();

        $error = $authenticationUtils->getLastAuthenticationError();
        
        return $this->render('security/login.html.twig', [
            'controller_name' => 'BackController',
            'splash' => $splash,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="LogOut")
     */
    Public function logout() {}
}

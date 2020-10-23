<?php

namespace App\Controller;

use App\Entity\Splash;
use App\Entity\Segments;

use App\Form\SplashType;

use App\Repository\SplashRepository;
use App\Repository\SegmentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackController extends AbstractController
{


    /**
     * @Route("/splashPage/{id}", name="splashPage")
     */
    public function splashPage(Splash $splash = null, SplashRepository $repo,  Request $request, EntityManagerInterface $manager)
    {
        if(!$splash) 
        {
            $splash = new Splash(); 
        }

        $update = $repo->findAll();

        $form = $this->createForm(SplashType::class, $splash);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $splash->setCreatedAt(new \DateTime());
            $manager->persist($splash);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your splash page has been updated and it look AWESOME !'
            );

            return $this->render('back/splashPage.html.twig', [
                'controller_name' => 'BackController',
                'form' => $form->createView(),
                'update' => $update
            ]);
        }

        return $this->render('back/splashPage.html.twig', [
            'controller_name' => 'BackController',
            'form' => $form->createView(),
            'update' => $update
        ]);
    }

    /**
     * @Route("/segmentView", name="segmentView")
     */
    public function segmentView(SegmentsRepository $repo)
    {
        $segments = $repo->findBy(['deleted'=>false]);

        $trash = $repo->findBy(['deleted'=>true]);

        return $this->render('back/segmentView.html.twig', [
            'controller_name' => 'BackController',
            'segments' => $segments,
            'trash' => $trash
        ]);
    }
        
    /**
     * @Route("/segmentAdd", name="segmentAdd")
     * @Route("/segmentEdit/{id}", name="segmentEdit")
     */
    public function segmentForm(Segments $segments = null, Request $request, EntityManagerInterface $manager)
    {
        if(!$segments) {
        $segments = new Segments(); 
        }

        $form = $this->createFormBuilder($segments)
                    ->add('part', TextType::class)
                    ->add('title1', TextType::class)
                    ->add('message1', TextareaType::class)
                    ->add('link1', TextType::class)
                    ->add('title2', TextType::class)
                    ->add('message2', TextareaType::class)
                    ->add('link2', TextType::class, ['required'=>false])
                    ->add('link_s1', TextType::class, ['required'=>false])
                    ->add('link_s2', TextType::class, ['required'=>false])
                    ->add('link_s3', TextType::class, ['required'=>false])
                    ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $segments->setCreatedAt(new \DateTime());
            $segments->setDeleted(false);
            $manager->persist($segments);
            $manager->flush();

            return $this->redirectToRoute('segmentView');
        }
        
        return $this->render('back/segmentForm.html.twig', [
            'formSegment' => $form->createView(),
            'editMode' => $segments->getId() !==null
        ]);
    }

     /**
     * @Route("/segmentBin/{id}", name="segmentBin")
     */
    public function segmentBin($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $delete = $entityManager->getRepository(segments::class)->find($id);

        $delete->setDeleted(true);
        $entityManager->flush();

        $this->addFlash(
            'warning',
            'Your segment have been placed in the trash.'
        );

        return $this->redirectToRoute('segmentView');
    }

    /**
     * @Route("/segmentRft/{id}", name="removeFromTrash")
     */
    public function removeFromTrash($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $remove = $entityManager->getRepository(segments::class)->find($id);

        $remove->setDeleted(false);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Your segment have removed from the trash.'
        );

        return $this->redirectToRoute('segmentTrash');
    }

    /**
     * @Route("/segmentDft/{id}", name="deleteFromTrash")
     */
    public function deleteFromTrash($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $permDelete = $entityManager->getRepository(segments::class)->find($id);

        $entityManager->remove($permDelete);
        $entityManager->flush();

        $this->addFlash(
            'danger',
            'Your segment have permanently deleted.'
        );

        return $this->redirectToRoute('segmentTrash');
    }

    /**
     * @Route("/segmentTrashAll", name="TrashAll")
     */
    public function TrashAll()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $deleteAll = $entityManager->getRepository(segments::class)->findBy(['deleted'=>true]);

        foreach ($deleteAll as $newDelete) {
            $entityManager->remove($newDelete);
            $entityManager->flush();
        }

        return $this->redirectToRoute('segmentView');
    }

    /**
     * @Route("/segmentTrash", name="segmentTrash")
     */
    public function segmentTrash(SegmentsRepository $repo)
    {
        $trash = $repo->findBy(['deleted'=>true]);

            if ($trash == true) 
            {
                $segments = $repo->findBy(['deleted'=>true]);

                return $this->render('back/segmentTrash.html.twig', [
                    'controller_name' => 'BackController',
                    'segments' => $segments
                ]);
            } else {
                return $this->redirectToRoute('segmentView');
            }
    }
}
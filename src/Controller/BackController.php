<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Segments;
use App\Repository\SegmentsRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BackController extends AbstractController
{


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
    public function segmentView(SegmentsRepository $repo)
    {
        $segments = $repo->findBy(['deleted'=>false]);

        return $this->render('back/segmentView.html.twig', [
            'controller_name' => 'BackController',
            'segments' => $segments
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
                    ->add('link2', TextType::class)
                    ->add('link_s1', TextType::class)
                    ->add('link_s2', TextType::class)
                    ->add('link_s3', TextType::class)
                    ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            $segments->setCreatedAt(new \DateTime());
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
     * @Route("/segmentBin", name="segmentBin")
     */
    public function segmentBin()
    {
        return $this->render('back/segmentView.html.twig', [
            'controller_name' => 'BackController',
        ]);
    }

    /**
     * @Route("/segmentTrash", name="segmentTrash")
     */
    public function segmentTrash(SegmentsRepository $repo)
    {

        $segments = $repo->findBy(['deleted'=>true]);

        return $this->render('back/segmentTrash.html.twig', [
            'controller_name' => 'BackController',
            'segments' => $segments
        ]);
    }
}
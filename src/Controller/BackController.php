<?php

namespace App\Controller;

use App\Entity\Splash;
use App\Entity\Segments;

use App\Form\SplashType;

use App\Form\SegmentType;
use App\Repository\SplashRepository;
use App\Repository\SegmentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
    public function segmentForm(Segments $segments = null, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        if(!$segments) {
        $segments = new Segments(); 
        }

        $form = $this->createForm(SegmentType::class, $segments);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            /** @var UploadedFile $link1 */
            $link1 = $form->get('link_s1')->getData();
            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($link1) {
                $originalFilename = pathinfo($link1->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$link1->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $link1->move(
                        $this->getParameter('links_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $segments->setlinkS1($newFilename);
            }

            $segments->setCreatedAt(new \DateTime());
            $segments->setDeleted(false);
            $manager->persist($segments);
            $manager->flush();

            $this->addFlash(
                'success',
                'Your segment have been updeated.'
            );

            return $this->redirect($request->getUri());
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
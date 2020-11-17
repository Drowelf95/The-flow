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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackController extends AbstractController
{


    /**
     * @Route("/splashPage/{id}", name="splashPage")
     */
    public function splashPage(Splash $splash = null, SplashRepository $repo,  Request $request, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
 

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
    public function segmentForm(Segments $segments = null, SegmentsRepository $repo, Request $request, EntityManagerInterface $manager, SluggerInterface $slugger)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if(!$segments) {
            $segments = new Segments(); 
            $updates = null;
        } else {
            $updates = $repo->find($segments);
        }

        $form = $this->createForm(SegmentType::class, $segments);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) 
        {
            /** @var UploadedFile $link1 */
            $link1 = $form->get('link_s1')->getData();
            $link2 = $form->get('link_s2')->getData();
            $link3 = $form->get('link_s3')->getData();
            

            if ($link1) {
                $originalFilename = pathinfo($link1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$link1->guessExtension();

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

            if ($link2) {
                $originalFilename = pathinfo($link2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$link2->guessExtension();

                try {
                    $link2->move(
                        $this->getParameter('links_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $segments->setlinkS2($newFilename);
            }

            if ($link3) {
                $originalFilename = pathinfo($link3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$link3->guessExtension();

                try {
                    $link3->move(
                        $this->getParameter('links_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $segments->setlinkS3($newFilename);
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
            'editMode' => $segments->getId() !==null,
            'updates' => $updates
        ]);
    }

    /**
     * @Route("/segmentImgT1/{id}", name="segmentImgTrash1")
     */
    public function segmentImgTrash(Segments $segments, EntityManagerInterface $manager, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $name = $segments->getlinkS1(); 
        unlink($this->getParameter('links_directory'). '/'.$name);

        $segments->setLinkS1(null);
        $manager->persist($segments);
        $manager->flush();

        return $this->redirectToRoute('segmentEdit', [
            'id' => $segments->getId()
        ]);
    }

        /**
     * @Route("/segmentImgT2/{id}", name="segmentImgTrash2")
     */
    public function segmentImgTrash2(Segments $segments, EntityManagerInterface $manager, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $name = $segments->getlinkS2(); 
        unlink($this->getParameter('links_directory'). '/'.$name);

        $segments->setLinkS2(null);
        $manager->persist($segments);
        $manager->flush();

        return $this->redirectToRoute('segmentEdit', [
            'id' => $segments->getId()
        ]);
    }

        /**
     * @Route("/segmentImgT3/{id}", name="segmentImgTrash3")
     */
    public function segmentImgTrash3(Segments $segments, EntityManagerInterface $manager, Request $request)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $name = $segments->getlinkS3(); 
        unlink($this->getParameter('links_directory'). '/'.$name);

        $segments->setLinkS3(null);
        $manager->persist($segments);
        $manager->flush();

        return $this->redirectToRoute('segmentEdit', [
            'id' => $segments->getId()
        ]);
    }

     /**
     * @Route("/segmentBin/{id}", name="segmentBin")
     */
    public function segmentBin($id)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
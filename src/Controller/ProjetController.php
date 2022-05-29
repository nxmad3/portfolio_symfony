<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\User;
use App\Form\ProjetType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProjetController extends AbstractController
{

    #[Route('admin/suppProjet/{id}', name: 'suppProjet')]
    public function suppProjet(int $id, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $projet = $entityManager->getRepository(Projet::class)->find($id);
        $entityManager->remove($projet);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }


    #[Route('admin/ajouterProjet', name: 'ajouterProjet')]
    public function ajouterProjet(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, KernelInterface $appKernel): Response
    {
        $entityManager = $doctrine->getManager();
        $projet = new Projet();
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());
        $lesImages = [];
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            if ($form->get('images')->getData() !== null && $form->get('pdfName')->getData() !== null) {
                $pdf = $form->get('pdfName')->getData();
                $images = $form->get('images')->getData();
                foreach ($images as $image) {
                    if ($images) {
                        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                        // this is needed to safely include the file name as part of the URL
                        $safeFilename = $slugger->slug($originalFilename);
                        $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                        // Move the file to the directory where image are stored
                        try {
                            $image->move(
                                $this->getParameter('images_directory'),
                                $newFilename
                            );
                        } catch (FileException $e) {
                            // ... handle exception if something happens during file upload
                        }
                        $lesImages[] = $newFilename;
//
                    }
                }
                $projet->setImages($lesImages);

                // this condition is needed because the 'brochure' field is not required
                // so the PDF file must be processed only when a file is uploaded
                if ($pdf) {
                    $originalFilename = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $pdf->guessExtension();

                    // Move the file to the directory where pdf are stored
                    try {
                        $pdf->move(
                            $this->getParameter('pdf_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }

                    $projet->setPdfName($newFilename);
                }
            }

            $projet->setUser($user);
            $entityManager->persist($projet);
            $entityManager->flush();
            return $this->redirectToRoute('admin');
        }
        return $this->renderForm('admin/ajouterProjet.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('admin/modifProjet/{id}', name: 'modifProjet')]
    public function modifProjet(int $id, Request $request, ManagerRegistry $doctrine , SluggerInterface $slugger): Response
    {
        $entityManager = $doctrine->getManager();
        $projet = $entityManager->getRepository(Projet::class)->find($id);
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        /** @var UploadedFile $brochureFile */
        if ($form->isSubmitted() && $form->isValid()) {
        if ($form->get('images')->getData() !== null && $form->get('pdfName')->getData() !== null) {
            $pdf = $form->get('pdfName')->getData();
            $images = $form->get('images')->getData();
            foreach ($images as $image) {
                if ($images) {
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                    // Move the file to the directory where image are stored
                    try {
                        $image->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
                    $lesImages[] = $newFilename;
//
                }
            }
            $projet->setImages($lesImages);

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($pdf) {
                $originalFilename = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pdf->guessExtension();

                // Move the file to the directory where pdf are stored
                try {
                    $pdf->move(
                        $this->getParameter('pdf_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $projet->setPdfName($newFilename);
            }
        }
        $entityManager->persist($projet);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }
        return $this->renderForm('admin/modifProjet.html.twig', [
            'form' => $form,
        ]);
    }
}

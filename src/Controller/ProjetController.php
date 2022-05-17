<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Pdf;
use App\Entity\Projet;
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

    #[Route('/projet', name: 'app_projet')]
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProjetController.php',
        ]);
    }

    #[Route('admin/ajouterProjet', name: 'ajouterProjet')]
    public function ajouterProjet(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, KernelInterface $appKernel): Response
    {
        $entityManager = $doctrine->getManager();
        $projet = new Projet();
        $nb =0;
        $lesImages = [];
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $brochureFile */
            $pdf = $form->get('pdfName')->getData();
            $images =$form->get('images')->getData();
            foreach($images as $image){
                $nb = $nb+ 1;
                if ($images) {
                    $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                    // this is needed to safely include the file name as part of the URL
                    $safeFilename = $slugger->slug($originalFilename);
                    $newFilename = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();

                    // Move the file to the directory where brochures are stored
                    try {
                        $image->move(
                            $this->getParameter('images_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        // ... handle exception if something happens during file upload
                    }
                    // updates the 'brochureFilename' property to store the PDF file name
                    // instead of its contents
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

                // Move the file to the directory where brochures are stored
                try {
                    $pdf->move(
                        $this->getParameter('pdf_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $projet->setPdfName($newFilename);
            }

            // ... persist the $product variable or any other work


//            $file = $request->files->get("projet[_token]");
//            $inventory_file = $file["image"];
//            $photo_file = $file["file"];
//            $targetDir = $appKernel->getProjectDir() . "/public/uploads";
//            $fileUploader = new FileUploader($targetDir, $slugger);
//            $projet
//                ->setInventoryFile($fileUploader->upload($inventory_file))
//                ->setFile($fileUploader->upload($photo_file));

            $entityManager->persist($projet);
            $entityManager->flush();
            dd($projet->getImages());
        }
        return $this->renderForm('admin/ajouterProjet.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('admin/modifProjet/{id}', name: 'modifProjet')]
    public function modifProjet(int $id, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $projet = $entityManager->getRepository(Projet::class)->find($id);
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        $entityManager->persist($projet);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->renderForm('admin/modifProjet.html.twig', [
            'form' => $form,
        ]);
    }

}

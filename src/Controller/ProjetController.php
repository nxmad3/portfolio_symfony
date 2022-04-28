<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Form\ProjetType;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $request->files->get("projet[_token]");
            dd($file);
            $inventory_file = $file["image"];
            $photo_file = $file["file"];
            $targetDir = $appKernel->getProjectDir() . "/public/uploads";
            $fileUploader = new FileUploader($targetDir, $slugger);
            $projet
                ->setInventoryFile($fileUploader->upload($inventory_file))
                ->setFile($fileUploader->upload($photo_file));
            $entityManager->persist($projet);
            $entityManager->flush();
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

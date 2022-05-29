<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\User;
use App\Form\CompetenceType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class CompetenceController extends AbstractController
{

    #[Route('admin/ajouterCompetence', name: 'ajouterCompetence')]
    public function ajouterCompetence(Request $request, ManagerRegistry $doctrine, SluggerInterface $slugger, KernelInterface $appKernel): Response
    {
        $entityManager = $doctrine->getManager();
        $Competence = new Competence();
        $user = $entityManager->getRepository(User::class)->find($this->getUser());
        $form = $this->createForm(CompetenceType::class, $Competence);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $Competence->setUser($user);
            $entityManager->persist($Competence);
            $entityManager->flush();
            return $this->redirectToRoute('admin'); // Redirection vers la page admin
        }


        return $this->renderForm('admin/ajouterCompetence.html.twig', ['form' => $form]);
    }

    #[Route('admin/modifCompetence/{id}', name: 'modifCompetence')]
    public function modifCompetence(int $id, Request $request, SluggerInterface $slugger,ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $Competence = $entityManager->getRepository(Competence::class)->find($id);
        $form = $this->createForm(CompetenceType::class, $Competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Competence);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
           return $this->redirectToRoute('admin');

        }

        return $this->renderForm('admin/modifCompetence.html.twig', [
            'form' => $form,

        ]);
    }

    #[Route('admin/suppCompetence/{id}', name: 'suppCompetence')]
    public function suppCompetence(int $id, Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $Competence = $entityManager->getRepository(Competence::class)->find($id);
        $entityManager->remove($Competence);
        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();
        return $this->redirectToRoute('admin');
    }
}
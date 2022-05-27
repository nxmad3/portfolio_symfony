<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
class Admin extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index( Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }
        return $this->render('admin/index.html.twig', [
            'user' => $user
        ]);
    }
}
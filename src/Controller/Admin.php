<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User;
class Admin extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }
        return $this->json([
            'path' => 'src/Controller/Admin/index.html.twig',
        ]);
    }
}
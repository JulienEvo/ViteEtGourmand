<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/profil', name: 'admin_profil_')]
class ProfilController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/profil/index.html.twig');
    }

    #[Route('/edit', name: 'edit')]
    public function edit(): Response
    {
        return $this->render('admin/profil/edit.html.twig');
    }
}

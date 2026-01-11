<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/societe', name: 'admin_societe_')]
class SocieteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/societe/index.html.twig');
    }

    #[Route('/edit', name: 'edit')]
    public function edit(): Response
    {
        return $this->render('admin/societe/edit.html.twig');
    }
}

<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/avis', name: 'admin_avis_')]
class AvisController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/avis/index.html.twig');
    }

    #[Route('/{id}/valide', name: 'valide')]
    public function valide(int $id): Response
    {
        return $this->redirectToRoute('admin_avis_index');
    }

    #[Route('/{id}/refuse', name: 'refuse')]
    public function refuse(int $id): Response
    {
        return $this->redirectToRoute('admin_avis_index');
    }
}

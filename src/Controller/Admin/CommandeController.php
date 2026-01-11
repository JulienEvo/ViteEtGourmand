<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/commande', name: 'admin_commande_')]
class CommandeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/commande/index.html.twig');
    }

    #[Route('/{id}', name: 'show')]
    public function show(int $id): Response
    {
        return $this->render('admin/commande/show.html.twig', [
            'id' => $id
        ]);
    }

    #[Route('/{id}/status', name: 'status', methods: ['POST'])]
    public function updateStatus(int $id): Response
    {
        return $this->redirectToRoute('admin_commande_show', ['id' => $id]);
    }
}

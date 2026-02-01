<?php

namespace App\Controller;

use App\Repository\GeneriqueRepository;
use App\Repository\SocieteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        SocieteRepository $societeRepository,
        GeneriqueRepository $generiqueRepository
    ): Response
    {
        $societe = $societeRepository->findById(1);
        $plat_type = $generiqueRepository->findAll('plat_type');

        return $this->render('home/index.html.twig', [
            'societe' => $societe,
            'plat_type' => $plat_type,
        ]);
    }
}

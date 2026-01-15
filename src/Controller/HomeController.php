<?php

namespace App\Controller;

use App\Repository\GeneriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(GeneriqueRepository $generiqueRepository): Response
    {
        $plat_type = $generiqueRepository->findAll('plat_type');

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'plat_type' => $plat_type,
        ]);
    }
}

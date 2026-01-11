<?php

namespace App\Controller;

use App\Entity\Generique;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menu', name: 'menu_')]
class MenuController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, MenuRepository $menuRepository, GeneriqueRepository $generiqueRepository): Response
    {
        $filters = [
            'term' => $request->query->get('term'),
            'theme' => $request->query->get('theme'),
            'tarif_max' => $request->query->get('tarif_max'),
            'disponible' => $request->query->get('disponible'),
        ];

        $themes = $generiqueRepository->findAll('menu_theme');

        $regimes = $generiqueRepository->findAll('menu_regime');


        $menus = $menuRepository->findByFilters($filters);

        return $this->render('menu/index.html.twig', [
            'menus' => $menus,
            'filters' => $filters,
            'themes' => $themes,
            'regimes' => $regimes,
        ]);
    }

    #[Route('/show/{id}', name: 'show')]
    public function show(int $id, MenuRepository $menuRepository): Response
    {
        $menu = $menuRepository->findById($id);

        if (!$menu) {
            throw $this->createNotFoundException('Menu introuvable');
        }

        return $this->render('menu/liste.html.twig', [
            'menu' => $menu
        ]);
    }
}

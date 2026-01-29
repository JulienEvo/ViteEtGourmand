<?php

namespace App\Controller;

use App\Entity\Generique;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuRepository;
use App\Repository\PlatRepository;
use App\Repository\PlatTypeRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/menus', name: 'menu_')]
class MenuController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, MenuRepository $menuRepository, GeneriqueRepository $generiqueRepository): Response
    {
        $filters = [
            'term' => $request->query->get('term'),
            'theme' => $request->query->get('theme'),
            'regime' => $request->query->get('regime'),
            'tarif_min' => $request->query->get('tarif_min'),
            'tarif_max' => $request->query->get('tarif_max'),
            'disponible' => $request->query->get('disponible'),
        ];

        $themes = $generiqueRepository->findAll('theme');

        $regimes = $generiqueRepository->findAll('regime');

        $menus = $menuRepository->findByFilters($filters);

        return $this->render('menu/index.html.twig', [
            'menus' => $menus,
            'filters' => $filters,
            'themes' => $themes,
            'regimes' => $regimes,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(
        int $id,
        Request $request,
        MenuRepository $menuRepository,
        PlatRepository $platRepository,
        GeneriqueRepository $generiqueRepository,
        PlatTypeRepository $platTypeRepository,
    ): Response
    {
        $menu = $menuRepository->findById($id);

        $plats = $platRepository->findByMenuId($id);
        $plat_types = $platTypeRepository->findAll();

        $plats_par_type = [];
        foreach ($plat_types as $type)
        {
            foreach ($plats as $plat)
            {
                if ($plat['type_id'] == $type['id'])
                {
                    $plats_par_type[$type['libelle']][$plat['id']] = $plat;
                }
            }
        }

        $themes = $generiqueRepository->findAll('theme');
        $regimes = $generiqueRepository->findAll('regime');

        return $this->render('menu/edit.html.twig', [
            'menu' => $menu,
            'plats' => $plats,
            'plats_par_type' => $plats_par_type,
            'themes' => $themes,
            'regimes' => $regimes,
        ]);
    }

    #[Route('/menus/filter', name: 'filter_ajax')]
    public function filter(Request $request, MenuRepository $menuRepository, GeneriqueRepository $generiqueRepository): Response
    {
        $filters = [
            'term' => $request->query->get('term'),
            'theme' => $request->query->get('theme'),
            'regime' => $request->query->get('regime'),
            'tarif_min' => $request->query->get('tarif_min'),
            'tarif_max' => $request->query->get('tarif_max'),
            'disponible' => $request->query->getBoolean('disponible'),
        ];

        $menus = $menuRepository->findByFilters($filters);

        $themes = $generiqueRepository->findAll('theme');

        $regimes = $generiqueRepository->findAll('regime');

        return $this->render('menu/_list.html.twig', [
            'menus' => $menus,
            'themes' => $themes,
            'regimes' => $regimes,
        ]);
    }

}

<?php

namespace App\Controller;

use App\Repository\AvisRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\SocieteRepository;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(
        SocieteRepository $societeRepository,
        GeneriqueRepository $generiqueRepository,
        AvisRepository $avisRepository,
        UserRepository $userRepository,
    ): Response
    {
        $societe = $societeRepository->findById(1);
        $plat_type = $generiqueRepository->findAll('plat_type');
        $tab_avis = $avisRepository->findAll(true);
        $tab_utilisateur = $userRepository->findAll();

        return $this->render('home/index.html.twig', [
            'societe' => $societe,
            'plat_type' => $plat_type,
            'tab_avis' => $tab_avis,
            'tab_utilisateur' => $tab_utilisateur,
        ]);
    }
}

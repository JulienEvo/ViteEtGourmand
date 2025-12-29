<?php

namespace App\Controller;

use App\Service\QueryService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(QueryService $queryService): Response
    {
        // Informations de la société
        $societe = $queryService->getSociete();

        // Horaires d'ouvertures
        $horaires = $queryService->getHoraire();

        // Les 10 dernièrs avis clients validés
        $lastAvis = $queryService->getLastAvis();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'societe' => $societe,
            'horaires' => $horaires,
            'lastAvis' => $lastAvis,
        ]);
    }
}

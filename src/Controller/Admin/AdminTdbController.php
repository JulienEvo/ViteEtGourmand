<?php

namespace App\Controller\Admin;

use App\Repository\AvisRepository;
use App\Repository\CommandeEtatRepository;
use App\Repository\CommandeRepository;
use App\Repository\GeneriqueRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_')]
class AdminTdbController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    public function index(
        CommandeRepository $commandeRepository,
        GeneriqueRepository $generiqueRepository,
        AvisRepository $avisRepository,
    ): Response
    {

        $utilisateur_id = 0;
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_EMPLOYE'))
        {
            $utilisateur_id = $this->getUser()->getId();
        }

        // COMMANDES
        $tab_commande_etat = $generiqueRepository->findAll('commande_etat');
        $tab_commande = $commandeRepository->findAll($utilisateur_id);

        foreach ($tab_commande_etat as $commande_etat_id => $commande_etat)
        {
            $tab_commande_etat[$commande_etat_id]['nb_commande'] = 0;
            $tab_commande_etat[$commande_etat_id]['lien'] = 0;
        }

        foreach ($tab_commande as $commande)
        {
            $tab_commande_etat[$commande->getCommande_etat_id()]['nb_commande']++;
        }

        // AVIS
        $tab_avis = $avisRepository->findAll();
        $tab_avis_valide = [
            'En attente' => 0,
            'Validé' => 0,
            'Refusé' => 0,
        ];
        foreach ($tab_avis as $avis)
        {
            if ($avis->getValide() == 0)
            {
                $tab_avis_valide['Refusé']++;
            }
            elseif ($avis->getValide() == 1)
            {
                $tab_avis_valide['Validé']++;
            }
            else
            {
                $tab_avis_valide['en attente']++;
            }
        }

        return $this->render('admin/dashboard.html.twig', [
            'tab_commande_etat' => $tab_commande_etat,
            'tab_avis_valide' => $tab_avis_valide,
            'nb_avis' => count($tab_avis),
        ]);
    }
}

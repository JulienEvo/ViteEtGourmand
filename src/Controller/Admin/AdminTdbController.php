<?php

namespace App\Controller\Admin;

use App\Repository\AvisRepository;
use App\Repository\CommandeRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuRepository;
use App\Repository\PlatRepository;
use MongoDB\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'admin_tdb_')]
class AdminTdbController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        CommandeRepository $commandeRepository,
        GeneriqueRepository $generiqueRepository,
        AvisRepository $avisRepository,
        PlatRepository $platRepository,
        GeneriqueRepository $platTypeRepository,
        MenuRepository $menuRepository,
    ): Response
    {
        $utilisateur_id = 0;
        if (!$this->isGranted('ROLE_ADMIN') && !$this->isGranted('ROLE_EMPLOYE'))
        {
            $utilisateur_id = $this->getUser()->getId();
        }

        // PLATS
        $tab_plat = $platRepository->findAll();
        $tab_plat_type = $platTypeRepository->findAll('plat_type');

        foreach( $tab_plat as $plat_id => $plat )
        {
            if (array_key_exists($plat->getType_id(), $tab_plat_type))
            {
                if (isset($tab_plat_type[$plat->getType_id()]['nb_plat']))
                {
                    $tab_plat_type[$plat->getType_id()]['nb_plat']++;
                }
                else
                {
                    $tab_plat_type[$plat->getType_id()]['nb_plat'] = 1;
                }
            }
        }

        // MENUS
        $tab_menu = $menuRepository->findAll();

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
                $tab_avis_valide['En attente']++;
            }
        }

        // STATISTIQUES
        $stat_commande = [];
        $stat_avis = [];
        if (extension_loaded('mongodb')) {
            $client = new Client($_ENV['MONGODB_URL']);
            $mongo_db = $client->vite_et_gourmand_stats;

            // --> Commandes
            $tb_commande = $mongo_db->commande;
            $res = $tb_commande->aggregate(
                [[
                    '$group' => [
                        '_id' => '$menu_libelle',
                        'total' => ['$sum' => '$quantite'],
                        'ca' => ['$sum' => '$total_ttc']
                    ]
                ]]
            );

            foreach ($res as $row) {
                $stat_commande[] = [
                    'menu_libelle' => $row->_id,
                    'total' => $row->total,
                    'ca' => $row->ca
                ];
            }

            // --> Avis
            $tb_avis = $mongo_db->avis;
            $res2 = $tb_avis->aggregate(
                [[
                    '$group' => [
                        '_id' => '$menu_libelle',
                        'note_moyenne' => ['$avg' => '$note']
                    ]
                ]]
            );

            foreach ($res2 as $row) {
                $stat_avis[] = [
                    'menu_libelle' => $row->_id,
                    'note_moyenne' => round($row->note_moyenne, 2)
                ];
            }
        }
        else
        {
            $stat_commande = $commandeRepository->getStatCommande();
            $stat_avis = $avisRepository->getStatAvis();
        }

        return $this->render('admin/tdb/index.html.twig', [
            'tab_commande_etat' => $tab_commande_etat,
            'tab_avis_valide' => $tab_avis_valide,
            'nb_commande' => count($tab_commande) ?? 0,
            'nb_avis' => count($tab_avis),
            'tab_plat' => $tab_plat,
            'tab_plat_type' => $tab_plat_type,
            'stat_commande' => $stat_commande,
            'stat_avis' => $stat_avis,
        ]);
    }
}

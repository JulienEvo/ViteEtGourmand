<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuRepository;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

const BORDEAUX_LAT = 44.837789;
const BORDEAUX_LON = -0.57918;

#[Route('/admin/commande', name: 'admin_commande_')]
class AdminCommandeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        CommandeRepository $commandeRepository,
        GeneriqueRepository $generiqueRepository,
        UserRepository $userRepository,
        MenuRepository $menuRepository,
        Request $request,
    ): Response
    {
        $filtre_etat = $request->query->get('filtre_etat', 0);

        $listeCommandes = $commandeRepository->findAll();
        $listeEtats = $generiqueRepository->findAll('commande_etat');
        $listeUtilisateurs = $userRepository->findAll();
        $listeMenus = $menuRepository->findAll();

        $tabCommande = [];
        foreach ($listeCommandes as $commande_id => $commande)
        {
            if ($filtre_etat == 0 || $filtre_etat == $commande->getCommande_etat_id())
            {
                $tabCommande[$commande_id]['commande'] = $commande;
                $tabCommande[$commande_id]['commande_etat'] = $listeEtats[$commande->getCommande_etat_id()];
                $tabCommande[$commande_id]['utilisateur'] = $listeUtilisateurs[$commande->getUtilisateur_id()];
                $tabCommande[$commande_id]['menu'] = $listeMenus[$commande->getMenu_id()];
            }
        }

        return $this->render('admin/commande/index.html.twig', [
            'tabCommande' => $tabCommande,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(
        int $id,
        CommandeRepository $commandeRepository,
        UserRepository $userRepository,
        MenuRepository $menuRepository,
        GeneriqueRepository $generiqueRepository,
        Request $request
    ): Response
    {

        if ($request->isMethod('POST'))
        {
            //--- VALIDATION DU FORMULAIRE ---//
            $numero = $request->request->get('numero');
            if ($numero == "")
            {
                $numero = $commandeRepository->getNumero();
            }

            $utilisateur = $userRepository->findById($request->request->get('utilisateur_id'));

            $commande = new Commande(
                $id,
                $request->request->get('menu_id'),
                $request->request->get('utilisateur_id'),
                $request->request->get('commande_etat_id'),
                $numero,
                new \DateTime($request->request->get('date_livraison')),
                $utilisateur->getAdresse(),
                $utilisateur->getCode_postal(),
                $utilisateur->getCommune(),
                $utilisateur->getLatitude(),
                $utilisateur->getLongitude(),
                $request->request->get('quantite', 0),
                $request->request->get('total_ttc', 0),
                $request->request->get('remise', 0),
            );

            if ($id == 0)
            {
                $retour = $commandeRepository->insert($commande);
                $mode = "ajoutée";
            }
            else
            {
                $retour = $commandeRepository->update($commande);
                $mode = "modifiée";
            }

            if (is_int($retour))
            {
                $id = $retour;
                $this->addFlash('success', "Commande {$mode} avec succès");
            }
            else
            {
                $this->addFlash('danger', "Erreur lors de l'enregistrement de la commande : " . $retour['message']);
            }

            return $this->redirectToRoute('admin_commande_edit', ['id' => $id]);
        }

        $commande = $commandeRepository->findById($id);

        $tabUtilisateur = $userRepository->findAll('ROLE_USER');
        $tabMenu = $menuRepository->findAll(true);
        $tabCommandeEtat = $generiqueRepository->findAll('commande_etat');

        return $this->render('admin/commande/edit.html.twig', [
            'id' => $id,
            'commande' => $commande,
            'tabUtilisateur' => $tabUtilisateur,
            'tabMenu' => $tabMenu,
            'tabCommandeEtat' => $tabCommandeEtat,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(int $id, CommandeRepository $commandeRepository): Response
    {
        $ret = $commandeRepository->delete($id);

        if ($ret)
        {
            $this->addFlash('success', 'Commande supprimée avec succès');
        }
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression de la commande : '.$ret);
        }

        return $this->redirectToRoute('admin_commande_index');
    }

    #[Route('/{id}/historique', name: 'historique')]
    public function historique(
        int $id,
        Security $security,
        CommandeRepository $commandeRepository,
        GeneriqueRepository $generiqueRepository,
        MenuRepository  $menuRepository,
    ): Response
    {
        // Historique de l'utilisateur connecté
        $user = $security->getUser();

        if (!$user) {
            return $this->redirectToRoute('login');
        }

        $tabCommande = $commandeRepository->findAll($user->getUserId());
        $tabMenu = $menuRepository->findAll();

        $tabCommandeEtat = [];
        $tab_commande_etat = $generiqueRepository->findAll('commande_etat');

        foreach ($tab_commande_etat as $commande_etat)
        {
            $tabCommandeEtat[$commande_etat['id']]['libelle'] = $commande_etat['libelle'];
            $tabCommandeEtat[$commande_etat['id']]['couleur'] = $commande_etat['couleur'];
        }

        return $this->render('admin/commande/historique.html.twig', [
            'tabCommande' => $tabCommande,
            'tabCommandeEtat' => $tabCommandeEtat,
            'tabMenu' => $tabMenu,
        ]);
    }

    #[Route('/{id}/visualisation', name: 'visualisation')]
    public function visualisation(
        int $id,
        CommandeRepository $commandeRepository,
        MenuRepository $menuRepository,
        GeneriqueRepository $generiqueRepository,
        UserRepository $userRepository,
    ): Response
    {
        $commande = $commandeRepository->findById($id);

        if (!$commande)
        {
            $this->addFlash('danger', 'Commande introuvable');
            return $this->redirectToRoute('admin_commande_edit', ['id' => $id]);
        }

        $menu = $menuRepository->findById($commande->getMenu_id());
        $tabCommande_etat = $generiqueRepository->findAll('commande_etat');

        $total_ttc = $menu->getTarif_unitaire() * $commande->getQuantite();

        if ($commande->getRemise() > 0)
        {
            $total_ttc -= ($total_ttc * $commande->getRemise() / 100);
        }

        // Calcule des frais de livraison
        $tarif_livraison = 0;
        $utilisateur = $this->getUser();

        if (!empty($utilisateur->getLatitude()))
        {
            $distance_km = FonctionsService::distanceKm(BORDEAUX_LAT, BORDEAUX_LON, $utilisateur->getLatitude(), $utilisateur->getLongitude());
            $tarif_livraison = round(5 + (0.59 * $distance_km), 2);
        }

        $commande->setTotal_ttc(round($total_ttc, 2));

        return $this->render('admin/commande/visualisation.html.twig', [
            'commande' => $commande,
            'menu' => $menu,
            'tabCommande_etat' => $tabCommande_etat,
            'tarif_livraison' => $tarif_livraison,
            'distance_km' => $distance_km,
        ]);
    }

}

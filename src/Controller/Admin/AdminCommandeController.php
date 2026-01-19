<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Repository\CommandeEtatRepository;
use App\Repository\CommandeRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuRepository;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/commande', name: 'admin_commande_')]
class AdminCommandeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        CommandeRepository $commandeRepository,
        GeneriqueRepository $generiqueRepository,
        UserRepository $userRepository,
        MenuRepository $menuRepository,
    ): Response
    {
        $listeCommandes = $commandeRepository->findAll();
        $listeEtats = $generiqueRepository->findAll('commande_etat');
        $listeUtilisateurs = $userRepository->findAll('ROLE_USER');
        $listeMenus = $menuRepository->findAll();

        $tabCommande = [];
        foreach ($listeCommandes as $commande_id => $commande)
        {
            $tabCommande[$commande_id]['commande'] = $commande;
            $tabCommande[$commande_id]['commande_etat'] = $listeEtats[$commande->getCommande_etat_id()];
            $tabCommande[$commande_id]['utilisateur'] = $listeUtilisateurs[$commande->getUtilisateur_id()];
            $tabCommande[$commande_id]['menu'] = $listeMenus[$commande->getMenu_id()];
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
        Request $request): Response
    {

        if ($request->isMethod('POST'))
        {
            //--- VALIDATION DU FORMULAIRE ---//
            $numero = $request->request->get('numero');
            if ($numero == "")
            {
                $numero = $commandeRepository->getNumero();
            }

            $commande = new Commande(
                $id,
                $request->request->get('menu_id'),
                $request->request->get('utilisateur_id'),
                $request->request->get('commande_etat_id'),
                $numero,
                new \DateTime($request->request->get('date_livraison')),
                $request->request->get('remise', 0),
            );

            $mode = "";
            if ($id == 0)
            {
                $retour = $commandeRepository->insert($commande);
                $mode = "ajoutée";;
            }
            else
            {
                $retour = $commandeRepository->update($commande);
                $mode = "modifiée";;
            }

            if (is_int($retour))
            {
                $id = $retour;
                $this->addFlash('success', "Commande {$mode} avec succès"); // MODIF : Ne marche pas, ajour dans layout.html.twig
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

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(int $id): Response
    {

        //...........


        return $this->redirectToRoute('admin_menu_index');
    }
}

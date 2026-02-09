<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use App\Repository\CommandeRepository;
use App\Repository\MenuRepository;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use MongoDB\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/avis', name: 'admin_avis_')]
class AdminAvisController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(AvisRepository $avisRepository, UserRepository $userRepository, CommandeRepository $commandeRepository): Response
    {
        $listAvis = $avisRepository->findAll();

        $tabAvis = [];
        foreach ($listAvis as $avis_id => $avis)
        {
            $utilisateur = $userRepository->findById($avis->getId());
            $commande = $commandeRepository->findById($avis->getId());

            $tabAvis[$avis_id]['avis'] = $avis;
            $tabAvis[$avis_id]['utilisateur'] = $utilisateur;
            $tabAvis[$avis_id]['commande'] = $commande;
        }

        return $this->render('admin/avis/index.html.twig', [
            'tabAvis' => $tabAvis,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(
        int $id,
        AvisRepository $avisRepository,
        UserRepository $userRepository,
        CommandeRepository $commandeRepository,
        MenuRepository $menuRepository,
        Request $request,
    ): Response
    {
        $avis = $avisRepository->findById($id);
        $tab_utilisateur = $userRepository->findAll();
        $tab_commande = $commandeRepository->findAll();
        $utilisateur_id = $request->query->get('utilisateur_id', 0);
        $commande_id = $request->query->get('commande_id', 0);
        $comeFrom = $request->query->get('comeFrom', '');

        if ($request->isMethod('POST'))
        {
            if (!$avis)
            {
                $avis = new Avis();
            }

            $avis->setUtilisateur_id($request->request->get('utilisateur_id'));
            $avis->setCommande_id($request->request->get('commande_id'));
            $avis->setNote($request->request->get('note'));
            $avis->setCommentaire($request->request->get('commentaire'));
            $avis->setValide(($request->request->get('valide') == '') ? null:$request->request->get('valide'));

            if ($avis->getId() == 0)
            {
                if ($avisRepository->insert($avis))
                {
                    $this->addFlash('success', "Avis enregistré avec succès");
                }
                else
                {
                    $this->addFlash('danger', "Échec lors de l'enregistrement de l'avis");
                }
            }
            else
            {
                if ($avisRepository->update($avis))
                {
                    $this->addFlash('success', "Avis modifié avec succès");
                }
            else
                {
                    $this->addFlash('danger', "Échec lors de la modification de l'avis");
                }
            }

            // Enregistre dans MongoDB pour les stats
            $client = new Client($_ENV['MONGODB_URL']);
            $mongo_db = $client->vite_et_gourmand_stats;

            $stats_commande = $mongo_db->avis;

            $created_at = $avis->getCreated_at();
            $menu = $menuRepository->findByCommandeId($commande_id);

            $stats_commande->insertOne([
                'id' => $avis->getId(),
                'utilisateur_id' => $avis->getUtilisateur_id(),
                'commande_id' => $avis->getCommande_id(),
                'note' => $avis->getNote(),
                'commentaire' => $avis->getCommentaire(),
                'valide' => $avis->getValide(),
                'created_at' => $created_at->format('Y-m-d H:i:s'),
                'menu_libelle' => $menu->getLibelle(),
            ]);

            if ($comeFrom == 'historique')
            {
                // on vient de l'historique de commande d'un USER : On retourne à l'historique
                return $this->redirectToRoute('admin_commande_visualisation', ['id' => $commande_id]);
            }
        }


        return $this->render('admin/avis/edit.html.twig', [
            'avis' => $avis,
            'tab_utilisateur' => $tab_utilisateur,
            'tab_commande' => $tab_commande,
            'utilisateur_id' => $utilisateur_id,
            'commande_id' => $commande_id,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(int $id): Response
    {
        return $this->render('admin/avis/index.html.twig');
    }

    #[Route('/{id}/valide', name: 'valide')]
    public function valide(int $id): Response
    {
        return $this->render('admin/avis/index.html.twig');
    }

    #[Route('/{id}/refuse', name: 'refuse')]
    public function refuse(int $id): Response
    {
        return $this->render('admin/avis/index.html.twig');
    }
}

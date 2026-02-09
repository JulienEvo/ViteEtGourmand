<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use App\Repository\AvisRepository;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
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
        Request $request,
    ): Response
    {
        $avis = $avisRepository->findById($id);
        $tab_utilisateur = $userRepository->findAll();
        $tab_commande = $commandeRepository->findAll();

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
        }

        return $this->render('admin/avis/edit.html.twig', [
            'avis' => $avis,
            'tab_utilisateur' => $tab_utilisateur,
            'tab_commande' => $tab_commande,
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

<?php

namespace App\Controller\Admin;

use App\Repository\SocieteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/societe', name: 'admin_societe_')]
class SocieteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/societe/index.html.twig');
    }

    #[Route('/edit', name: 'edit')]
    public function edit(SocieteRepository $societeRepository, Request $request): Response
    {
        $societe = $societeRepository->findById(1);

        if ($request->isMethod('POST'))
        {
            // Récupère les données du formulaire
            $societe->setLibelle(trim($request->request->get('libelle')));
            $societe->setStatut(trim($request->request->get('statut')));
            $societe->setCapital($request->request->get('capital'));
            $societe->setRcs(trim($request->request->get('rcs')));
            $societe->setTva(trim($request->request->get('tva')));
            $societe->setTelephone(trim($request->request->get('telephone')));
            $societe->setEmail(trim($request->request->get('email')));
            $societe->setAdresse(trim($request->request->get('adresse')));
            $societe->setCode_postal(trim($request->request->get('code_postal')));
            $societe->setCommune(trim($request->request->get('commune')));
            $societe->setPays(trim($request->request->get('pays')));
            $societe->setActif($request->request->get('actif') ?? true);

            if ($societeRepository->update($societe))
            {
                $this->addFlash('success', "Société modifiée avec succès");
            }
            else
            {
                $this->addFlash('danger', "Erreur lors de la modification de la société");
            }
        }

        return $this->render('admin/societe/edit.html.twig', [
            'societe' => $societe,
        ]);
    }
}

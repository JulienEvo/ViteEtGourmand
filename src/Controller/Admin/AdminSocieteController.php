<?php

namespace App\Controller\Admin;

use App\Repository\HoraireRepository;
use App\Repository\SocieteRepository;
use App\Service\FonctionsService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/societe', name: 'admin_societe_')]
class AdminSocieteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/societe/index.html.twig');
    }

    #[Route('/edit', name: 'edit')]
    public function edit(SocieteRepository $societeRepository, HoraireRepository $horaireRepository, Request $request): Response
    {
        $societe = $societeRepository->findById(1);
        $tabHoraire = $horaireRepository->findBySociete(1);

        if ($request->isMethod('POST')) {
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

            // HORAIRES
            foreach ($tabHoraire as $horaire_id => $horaire) {
                $ferme = $request->request->get('horaire_ferme_' . $horaire_id, false);

                if ($ferme) {
                    $horaire->setOuverture(null);
                    $horaire->setFermeture(null);
                    $horaire->setFerme(true);
                } else {
                    $horaire->setOuverture(new DateTime($request->request->get('horaire_ouverture_' . $horaire_id)));
                    $horaire->setFermeture(new DateTime($request->request->get('horaire_fermeture_' . $horaire_id)));
                    $horaire->setFerme(false);
                }

                $horaireRepository->update($horaire);
            }


            if ($societeRepository->update($societe)) {
                $this->addFlash('success', "Société modifiée avec succès");
            } else {
                $this->addFlash('danger', "Erreur lors de la modification de la société");
            }
        }

        return $this->render('admin/societe/edit.html.twig', [
            'societe' => $societe,
            'tabHoraire' => $tabHoraire,
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(SocieteRepository $societeRepository, HoraireRepository $horaireRepository, Request $request): Response
    {
        $societe = $societeRepository->findById(1);
        $tabHoraire = $horaireRepository->findBySociete(1);

        if ($request->isMethod('POST')) {
            $nom = trim($request->request->get('nom'));
            $email = trim($request->request->get('email'));
            $message = trim($request->request->get('message'));

            echo "ee : " . $message; exit;

            --> ENVOYER MAILss (Sauvegarde en bdd ???)

            $this->addFlash('success', "Votre message à bien été envoyé");
        }

        return $this->render('admin/societe/contact.html.twig');
    }

}

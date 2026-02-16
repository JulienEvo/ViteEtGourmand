<?php

namespace App\Controller\Admin;

use App\Repository\HoraireRepository;
use App\Repository\SocieteRepository;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
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
    public function contact(
        SocieteRepository $societeRepository,
        MailerInterface $mailer,
        Request $request
    ): Response
    {
        $societe = $societeRepository->findById(1);

        if ($request->isMethod('POST')) {
            $titre = trim($request->request->get('titre'));
            $email = trim($request->request->get('email'));
            $message = trim($request->request->get('message'));

            // Envoie email à l'administrateur
            $lien_repondre = "mailto:".$email;
            $email = (new Email())
                ->from('no-reply@vite-et-gourmand.fr')
                ->to($societe->getEmail())
                ->subject('Vite & Gourmand - Contact - '.$titre)
                ->html("
                            <p>
                                Bonjour,
                                <br><br>
                                Nouveau message via le formulaire de contact :
                                <br><br>
                                E-mail : {$email}<br>
                                Titre : {$titre}<br>
                                Message : {$message}<br>
                                <br>
                                Vous pouvez répondre au message en suivant ce lien :
                                <a href='{$lien_repondre}'>Répondre au message</a>
                                <br><br>
                                Cordialement,<br>
                                L’équipe <b>Vite & Gourmand</b>
                            </p>
                        "
                );

            try {
                $mailer->send($email);
                $this->addFlash('success', "Votre message à bien été envoyé");
            } catch (TransportExceptionInterface $e) {
                $this->addFlash('danger', 'Erreur lors de l’envoi du message : ' . $e->getMessage());
            }

            return $this->redirectToRoute('home');
        }

        return $this->render('admin/societe/contact.html.twig');
    }

    #[Route('/cgv', name: 'cgv')]
    public function cgv(
        SocieteRepository $societeRepository,
    ): Response
    {
        $societe = $societeRepository->findById(1);
        $tarif_livraison = 5;

        return $this->render('admin/societe/cgv.html.twig', [
            'societe' => $societe,
            'tarif_livraison' => $tarif_livraison,
        ]);
    }

    #[Route('/mentions', name: 'mentions')]
    public function mentions(
        SocieteRepository $societeRepository,
        UserRepository $userRepository,
    ): Response
    {
        $societe = $societeRepository->findById(1);
        $tab_admin = $userRepository->findAll('ROLE_ADMIN');
        foreach ($tab_admin as $user)
        {
            $admin = $user;
            break;
        }

        return $this->render('admin/societe/mentions.html.twig', [
            'societe' => $societe,
            'admin' => $admin,
        ]);
    }

}

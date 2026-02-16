<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Entity\Societe;
use App\Repository\AvisRepository;
use App\Repository\CommandeRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuRepository;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
                // Vérifie si le materiel a été restitué
                $class_danger = '';
                if ($commande->getPret_materiel() && $commande->getCommande_etat_id() == Commande::ETAT_EN_ATTENTE_MATERIEL)
                {
                    if ($commande->getDate()->modify('+10 days') < new DateTime('today') )
                    {
                        // La période de 10 jours pour réstituer le materiel est passée
                        $class_danger = ' style="background-color: #ffe7e3;" ';
                    }
                }

                $tabCommande[$commande_id]['commande'] = $commande;
                $tabCommande[$commande_id]['commande_etat'] = $listeEtats[$commande->getCommande_etat_id()];
                $tabCommande[$commande_id]['utilisateur'] = $listeUtilisateurs[$commande->getUtilisateur_id()];
                $tabCommande[$commande_id]['menu'] = $listeMenus[$commande->getMenu_id()];
                $tabCommande[$commande_id]['class_danger'] = $class_danger;
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
        MailerInterface $mailer,
        HttpClientInterface $httpClient,
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
                $request->request->get('pret_materiel', 0),
                $request->request->get('quantite', 0),
                $request->request->get('total_livraison', 0),
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

            // Si ETAT_EN_ATTENTE_MATERIEL, on envoi un email au client
            if ($commande->getCommande_etat_id() == Commande::ETAT_EN_ATTENTE_MATERIEL)
            {
                $lienContact = $this->generateUrl('contact', [], UrlGeneratorInterface::ABSOLUTE_URL);
                $email = (new Email())
                    ->from('no-reply@vite-et-gourmand.fr')
                    ->to($utilisateur->getEmail())
                    ->subject('Vite & Gourmand - Confirmation de votre commande')
                    ->html("
                            <p>
                                Bonjour {$utilisateur->getPrenom()},
                                <br><br>
                                Votre commande n°" . $commande->getNumero() . " a bien été livrée.
                                <br><br>
                                Du matériel de prêt vous a été fourni pour cette commande.
                                <br>
                                Merci de nous le restituer dans un délai de 10 jours ouvrés.
                                <br>
                                <span style='color: red'>Si vous dépassez ce délai, vous devrez vous acquitter de <b>600 €</b> de frais.</span>
                                <br><br>
                                Si vous avez la moindre question, notre équipe reste à votre disposition via le formulaire de contact :
                                <a href='{$lienContact}'>Formulaire de contact</a>
                                <br>
                                Nous vous remercions pour votre confiance.
                                <br>
                                Cordialement,<br>
                                L’équipe <b>Vite & Gourmand</b>
                            </p>
                        "
                    );

                $mailer->send($email);
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

        // Calcule des frais de livraison
        $distance_km = 0;
        $total_livraison = 5;
        $utilisateur = $this->getUser();

        if (strtoupper($utilisateur->getCommune()) != 'BORDEAUX' && !empty($utilisateur->getLatitude()))
        {
            $distance_km = FonctionsService::distanceKm(Societe::BORDEAUX_LAT, Societe::BORDEAUX_LON, $utilisateur->getLatitude(), $utilisateur->getLongitude(), $httpClient);

            if (!is_float($distance_km))
            {
                $data = json_decode($distance_km->getContent(), true);

                $this->addFlash('danger', $data['erreur'].$data['message']);
                return $this->redirectToRoute('admin_commande_edit', ['id' => $id]);
            }

            $total_livraison += round($distance_km * 0.59, 2);
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
            'distance_km' => $distance_km,
            'total_livraison' => $total_livraison,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(int $id, CommandeRepository $commandeRepository, Request $request): Response
    {
        $supprimer = $request->query->get('supprimer', false);
        $fromUser = $request->query->get('fromUser', 0);

        $mode = 'supprimée';
        if ($supprimer)
        {
            // Supprime la commande
            $ret = $commandeRepository->delete($id);
        }
        else
        {
            // Annule la commande
            $ret = ['error' => "Commande introuvable ({$id})"];
            $mode = 'annulée';

            $commande = $commandeRepository->findById($id);
            if (isset($commande))
            {
                $commande->setCommande_etat_id(Commande::ETAT_ANNULEE);

                $ret = $commandeRepository->update($commande);
            }
        }

        if (is_int($ret) || is_bool($ret))
        {
            $this->addFlash('success', "Commande {$mode} avec succès");
        }
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue : '.$ret['error']);
        }

        if ($fromUser == 1)
        {
            return $this->redirectToRoute('admin_commande_historique');
        }
        else
        {
            return $this->redirectToRoute('admin_commande_index');
        }
    }

    #[Route('/historique', name: 'historique')]
    public function historique(
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
        HttpClientInterface $httpClient,
        AvisRepository $avisRepository,
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
        $distance_km = 0;
        $total_livraison = 5;
        $utilisateur = $this->getUser();
        if (empty($commande->getTotal_livraison()))
        {
            if (strtoupper($utilisateur->getCommune()) != 'BORDEAUX' && !empty($utilisateur->getLatitude()))
            {
                $distance_km = FonctionsService::distanceKm(Societe::BORDEAUX_LAT, Societe::BORDEAUX_LON, $utilisateur->getLatitude(), $utilisateur->getLongitude(), $httpClient);

                if (!is_float($distance_km))
                {
                    $data = json_decode($distance_km->getContent(), true);

                    $this->addFlash('danger', $data['erreur'].$data['message']);
                    return $this->redirectToRoute('admin_commande_edit', ['id' => $id]);
                }

                $total_livraison += round($distance_km * 0.59, 2);
                $total_ttc += $total_livraison;
            }
            $commande->setTotal_livraison(round($total_livraison, 2));
        }

        $commande->setTotal_ttc(round($total_ttc, 2));

        $tab_avis = $avisRepository->findByParam($commande->getUtilisateur_id(), $commande->getId(), true);
        $tab_utilisateur = [$utilisateur->getId() => $utilisateur];

        return $this->render('admin/commande/visualisation.html.twig', [
            'commande' => $commande,
            'menu' => $menu,
            'tabCommande_etat' => $tabCommande_etat,
            'distance_km' => round($distance_km, 2),
            'tab_avis' => $tab_avis,
            'tab_utilisateur' => $tab_utilisateur,
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\HoraireRepository;
use App\Repository\MenuRepository;
use App\Repository\PlatRepository;
use App\Repository\PlatTypeRepository;
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

#[Route('/commande', name: 'commande_')]
class CommandeController extends AbstractController
{
    #[Route('/ajout', name: 'ajout')]
    public function ajout(
        MenuRepository $menuRepository,
        PlatRepository $platRepository,
        PlatTypeRepository $platTypeRepository,
        Request $request,
        Security $security
    ): Response
    {
        $menu_id = $request->query->get('menu_id', 0);
        $quantite = $request->query->get('quantite', 0);
        $utilisateur = $security->getUser();

        // Pas d'utilisateur connecté, redirige vers la page de connexion
        if (!$utilisateur) {
            return $this->redirectToRoute('login', [
                'redirect' => 'commande_ajout',
                'objet_id' => $menu_id,
            ]);
        }

        $menu_commande = $menuRepository->findById($menu_id);
        $plats_menu = $platRepository->findByMenuId($menu_id);

        $menus = $menuRepository->findAll(true);
        $plat_types = $platTypeRepository->findAll();

        return $this->render('commande/ajout.html.twig', [
            'utilisateur' => $utilisateur,
            'tabMenu' => $menus,
            'menu' => $menu_commande,
            'plats_menu' => $plats_menu,
            'plat_types' => $plat_types,
            'quantite' => $quantite,
        ]);
    }

    #[Route('/{commande_id}/validation', name: 'validation')]
    public function validation(
        int $commande_id,
        CommandeRepository $commandeRepository,
        UserRepository $userRepository,
        MenuRepository $menuRepository,
        HoraireRepository $horaireRepository,
        PlatRepository $platRepository,
        PlatTypeRepository $platTypeRepository,
        MailerInterface $mailer,
        Request $request):
    Response
    {
        $erreur = "";

        // Récupère les données du formulaire
        $utilisateur_id = $request->request->get('utilisateur_id');

        $commande_date = $request->request->get('commande_date');
        $commande_heure = $request->request->get('commande_heure');
        $info_suppl = $request->request->get('info_suppl');

        $menu_id = $request->request->get('menu_id');
        $quantite = $request->request->get('quantite');
        $remise = $request->request->get('remise');
        $total_ttc = $request->request->get('total_ttc');

        // Vérifie l'utilisateur connecté
        $utilisateur = $userRepository->findById($utilisateur_id);
        if (!$utilisateur) {
            $this->addFlash('danger', 'Veuillez vous connecter');
            $this->redirectToRoute('login');
        }

        // Vérifie le menu sélectionné
        $menu = $menuRepository->findById($menu_id);
        if (!$menu) {
            $this->addFlash('danger', 'menu inexistant');
            return $this->redirectToRoute('commande_ajout', ['menu_id' => $menu_id, 'quantite' => $quantite]);
        }

        // Vérifie les quantités disponibles
        $menu_commande = $menuRepository->findById($menu_id);
        $quantite_min = $menu_commande->getQuantite_min();
        $quantite_max = $menu_commande->getQuantite_disponible();
        if ($quantite < $quantite_min || $quantite > $quantite_max)
        {
            if ($quantite_max == 0)
            {
                $this->addFlash('danger', "Le menu est victime de son succès, veuillez choisir un autre menu");
            }
            else
            {
                $this->addFlash('danger', "La quantité doit être comprise entre " . $quantite_min . " et " . $quantite_max);
            }

            return $this->redirectToRoute('commande_ajout', [
                'menu_id' => $menu_id,
                'quantite' => $quantite_min,
                'commande_date' => $commande_date,
                'commande_heure' => $commande_heure,
            ]);
        }

        // Vérifie la date et l'heure de livraison
        $tabHoraire = $horaireRepository->findBySociete(1);

        $day_cmd = date('N', strtotime($commande_date));
        foreach ($tabHoraire as $horaire) {
            if ($horaire->getId() == $day_cmd) {
                if ($horaire->isFerme()) {
                    $erreur = "Désolé, nous sommes fermé le " . $horaire->getJour();
                }
                elseif ($commande_heure < $horaire->getOuverture() && $commande_heure >= $horaire->getFermeture()) {
                    $erreur = "heure souhaité hors des horaires d'ouverture du " . $horaire->getJour();
                }

                if ($erreur != "") {
                    $this->addFlash('danger', $erreur);
                    return $this->redirectToRoute('commande_ajout', [
                        'menu_id' => $menu_id,
                        'quantite' => $quantite_min,
                        'commande_date' => $commande_date,
                        'commande_heure' => $commande_heure,
                    ]);
                }
            }
        }


        // Ajouter la commande en bdd
        $numero = $commandeRepository->getNumero();
        $commande = new Commande(
            0,
            $utilisateur_id,
            $menu_id,
            1,
            $numero,
            new DateTime($commande_date.' '.$commande_heure),
            $quantite,
            $total_ttc,
            $remise,
            new DateTime()
        );

        $commande_id = $commandeRepository->insert($commande);

        if (is_array($commande_id))
        {
            $this->addFlash('danger', "Erreur lors de l'enregistrement de la commande : " . $commande_id['message']);
            return $this->redirectToRoute('commande_ajout', [
                'menu' => $menu,
                'quantite' => $quantite,
                'commande_date' => $commande_date,
                'commande_heure' => $commande_heure,
                'utilisateur_id' => $utilisateur_id,
            ]);
        }

        $commande = $commandeRepository->findById($commande_id);

        // Envoi email au client
        $date_commande = $commande->getCreated_at()->format('d/m/Y');
        $date_livraison = $commande->getDate()->format('d/m/Y');
        $lienContact = $this->generateUrl('contact', [], UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new Email())
            ->from('no-reply@vite-et-gourmand.fr')
            ->to($utilisateur->getEmail())
            ->subject('Vite & Gourmand - Confirmation de votre commande')
            ->html("
                            <p>
                                Bonjour {$utilisateur->getPrenom()},
                                <br><br>
                                Nous vous remercions pour votre commande passée sur notre site.
                                <br>
                                Nous vous confirmons que votre commande n°{$commande->getNumero()} a bien été prise en compte et est actuellement en cours de traitement.
                                <br>
                                <h2>Récapitulatif de la command</h2>
                                <br>
                                Date de commande : {$date_commande}<br>
                                Date de livraison : {$date_livraison}<br>
                                Montant total : {$commande->getTotal_ttc()} €<br>
                                <br>
                                Si vous avez la moindre question, notre équipe reste à votre disposition via le formulaire de contact :
                                <a href='{$lienContact}'>Formulaire de contact</a>
                                <br>
                                Nous vous remercions pour votre confiance et espérons vous revoir très bientôt.
                                <br>
                                Cordialement,<br>
                                L’équipe <b>Vite & Gourmand</b>
                            </p>
                        "
            );

        $mailer->send($email);

        $this->addFlash('success', "Commande validée avec succès");
        return $this->redirectToRoute('commande_historique', [
            'id' => $commande_id,
        ]);
    }

    #[Route('/historique', name: 'historique')]
    public function historique(CommandeRepository $commandeRepository, GeneriqueRepository $generiqueRepository, MenuRepository $menuRepository, Security $security): Response
    {
        $tabCommande = $commandeRepository->findAll($security->getUser()->getId());
        $tabCommandeEtat = $generiqueRepository->findAll('commande_etat');
        $tabMenu = $menuRepository->findAll();

        return $this->render('admin/commande/historique.html.twig', [
            'tabCommande' => $tabCommande,
            'tabCommandeEtat' => $tabCommandeEtat,
            'tabMenu' => $tabMenu,
        ]);
    }

        #[Route('/loadMenu/{id}', name: 'load_menu_ajax', methods: ['GET'])]
    public function loadMenu(int $id, MenuRepository $menuRepository, PlatRepository $platRepository, PlatTypeRepository $platTypeRepository): JsonResponse
    {
        $menu = $menuRepository->findById($id);

        if (!$menu)
        {
            return new JsonResponse(['erreur' => 'Menu introuvable'], Response::HTTP_NOT_FOUND);
        }

        $plats_menu = $platRepository->findByMenuId($menu->getId());
        $plat_types = $platTypeRepository->findAll();

        return new JsonResponse([
            'menu' => $menu,
            'tarif_unitaire'   => $menu->getTarif_unitaire(),
            'quantite_min'   => $menu->getQuantite_min(),
            'quantite_disponible'   => $menu->getQuantite_disponible(),
            'conditions' => $menu->getConditions(),
            'composition_menu' => $this->renderView('commande/_composition_menu.html.twig', ['plats_menu' => $plats_menu, 'plat_types' => $plat_types]),
         ]);
    }

}

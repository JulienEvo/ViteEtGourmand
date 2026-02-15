<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Societe;
use App\Repository\CommandeRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\HoraireRepository;
use App\Repository\MenuRepository;
use App\Repository\PlatRepository;
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
use MongoDB\Client;

#[Route('/commande', name: 'commande_')]
class CommandeController extends AbstractController
{
    #[Route('/ajout', name: 'ajout')]
    public function ajout(
        MenuRepository $menuRepository,
        PlatRepository $platRepository,
        GeneriqueRepository $platTypeRepository,
        Request $request,
        Security $security
    ): Response
    {
        $menu_id = $request->query->get('menu_id', 0);
        $quantite = $request->query->get('quantite', 0);
        $utilisateur = $security->getUser();

        // Pas d'utilisateur connecté, redirige vers la page de connexion
        if (!$utilisateur) {
            $this->addFlash('danger', "Veuillez d'abord vous connecter");
            return $this->redirectToRoute('login');
        }

        $menu_commande = $menuRepository->findById($menu_id);
        $plats_menu = $platRepository->findByMenuId($menu_id);

        $menus = $menuRepository->findAll(true);
        $plat_types = $platTypeRepository->findAll('plat_type');

        // MODIF : Afficher Frais de livraison
        $distance_km = 0;
        $total_livraison = 5;
        if (strtoupper($utilisateur->getCommune()) != 'BORDEAUX' &&  !empty($utilisateur->getLatitude()))
        {
            $distance_km = FonctionsService::distanceKm(Societe::BORDEAUX_LAT, Societe::BORDEAUX_LON, $utilisateur->getLatitude(), $utilisateur->getLongitude());

            if (!is_float($distance_km))
            {
                $data = json_decode($distance_km->getContent(), true);

                $this->addFlash('danger', $data['erreur'].$data['message']);
                return $this->redirectToRoute('admin_commande_edit', ['id' => $id]);
            }

            $total_livraison += round($distance_km * 0.59, 2);

        }

        return $this->render('commande/ajout.html.twig', [
            'utilisateur' => $utilisateur,
            'tabMenu' => $menus,
            'menu' => $menu_commande,
            'plats_menu' => $plats_menu,
            'plat_types' => $plat_types,
            'quantite' => $quantite,
            'total_livraison' => $total_livraison,
            'distance_km' => $distance_km,
        ]);
    }

    #[Route('/{commande_id}/validation', name: 'validation')]
    public function validation(
        CommandeRepository $commandeRepository,
        UserRepository $userRepository,
        MenuRepository $menuRepository,
        HoraireRepository $horaireRepository,
        MailerInterface $mailer,
        HttpClientInterface $httpClient,
        Request $request):
    Response
    {
        $erreur = "";

        // Récupère les données du formulaire
        $utilisateur_id = $request->request->get('utilisateur_id');

        $commande_date = $request->request->get('commande_date');
        $commande_heure = $request->request->get('commande_heure');
        $info_suppl = $request->request->get('info_suppl');

        $menu_id = $request->request->getInt('menu_id');
        $quantite = $request->request->getInt('quantite');
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

        // Calcule des frais de livraison
        $total_livraison = 5;
        $utilisateur = $this->getUser();

        if (!empty($utilisateur->getLatitude()))
        {
            $distance_km = $this->distanceKm(Societe::BORDEAUX_LAT, Societe::BORDEAUX_LON, $utilisateur->getLatitude(), $utilisateur->getLongitude(), $httpClient);

            if (!is_float($distance_km))
            {
                $data = json_decode($distance_km->getContent(), true);

                $this->addFlash('danger', $data['erreur'].$data['message']);
                return $this->redirectToRoute('commande_ajout', [
                    'menu_id' => $menu_id,
                    'quantite' => $quantite_min,
                    'commande_date' => $commande_date,
                    'commande_heure' => $commande_heure,
                ]);
            }

            $total_livraison += round($distance_km * 0.59, 2);
        }


        // Création de la commande
        $numero = $commandeRepository->getNumero();
        $commande = new Commande(
            0,
            $utilisateur_id,
            $menu_id,
            1,
            $numero,
            new DateTime($commande_date.' '.$commande_heure),
            $utilisateur->getAdresse(),
            $utilisateur->getCode_postal(),
            $utilisateur->getCommune(),
            $utilisateur->getLatitude(),
            $utilisateur->getLongitude(),
            $menu->getPret_materiel(),
            $quantite,
            $total_livraison,
            $total_ttc,
            $remise,
            new DateTime()
        );

        // Enregistrement de la commande en bdd
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
                                Remise : {$commande->getRemise()}<br>
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

        // Enregistrement pour les STATS (MongoDB)
        $client = new Client($_ENV['MONGODB_URL']);
        $mongo_db = $client->vite_et_gourmand_stats;

        $stats_commande = $mongo_db->commande;
    $res = $stats_commande->insertOne([
            'commande_id' => $commande_id,
            'commande_numero' => $commande->getNumero(),
            'utilisateur_id' => $utilisateur_id,
            'menu_id' => $menu_id,
            'menu_libelle' => $menu->getLibelle(),
            'quantite' => $quantite,
            'total_menu' => $menu_commande->getTarif_unitaire() * $quantite,
            'total_ttc' => $commande->getTotal_ttc(),
            'created_at' => $commande->getCreated_at()->format('Y-m-d H:i:s'),
        ]);


        $this->addFlash('success', "Commande validée avec succès");
        return $this->redirectToRoute('admin_commande_visualisation', [
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
    public function loadMenu(int $id, MenuRepository $menuRepository, PlatRepository $platRepository, GeneriqueRepository $platTypeRepository): JsonResponse
    {
        $menu = $menuRepository->findById($id);

        if ($id > 0 && !$menu)
        {
            return new JsonResponse(['erreur' => 'Menu introuvable'], Response::HTTP_NOT_FOUND);
        }

        $plats_menu = $platRepository->findByMenuId($menu->getId());
        $plat_types = $platTypeRepository->findAll('plat_type');

        return new JsonResponse([
            'menu' => $menu,
            'tarif_unitaire'   => $menu->getTarif_unitaire(),
            'quantite_min'   => $menu->getQuantite_min(),
            'quantite_disponible'   => $menu->getQuantite_disponible(),
            'conditions' => $menu->getConditions(),
            'composition_menu' => $this->renderView('commande/_composition_menu.html.twig', ['plats_menu' => $plats_menu, 'plat_types' => $plat_types]),
         ]);
    }

    public function distanceKm($lat1, $lon1, $lat2, $lon2, HttpClientInterface $client): float|JsonResponse
    {
        try {
            $response = $client->request(
                'POST',
                'https://api.openrouteservice.org/v2/directions/driving-car',
                [
                    'headers' => [
                        'Authorization' => $_ENV['ORS_API_KEY'],
                    ],
                    'json' => [
                        'coordinates' => [
                            [$lon1, $lat1],
                            [$lon2, $lat2],
                        ],
                    ],
                    'timeout' => 10,
                ]
            );

            $data = $response->toArray();

            // Retourne la distance Km
            return $data['routes'][0]['segments'][0]['distance'] / 1000;

        } catch (\Exception $e) {
            return $this->json([
                'erreur' => 'Erreur lors de l’appel à ORS : ',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}

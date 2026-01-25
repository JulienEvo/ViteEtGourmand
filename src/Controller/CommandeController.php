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
        UserRepository $userRepository,
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

        $menus = $menuRepository->findAll(true);
        $menu_commande = $menuRepository->findById($menu_id);
        $plats_menu = $platRepository->findByMenuId($menu_id);
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
        $menu_id = $request->request->get('menu_id');
        $quantite = $request->request->get('quantite');
        $commande_date = $request->request->get('commande_date');
        $commande_heure = $request->request->get('commande_heure');

        $utilisateur = $userRepository->findById($utilisateur_id);
        if (!$utilisateur) {
            $erreur = 'utilisateur inexistant';
        }

        $menu = $menuRepository->findById($menu_id);
        if (!$menu) {
            $erreur = 'menu inexistant';
        }

        $menus = $menuRepository->findAll(true);
        $menu_commande = $menuRepository->findById($menu_id);
        $plats_menu = $platRepository->findByMenuId($menu_id);
        $plat_types = $platTypeRepository->findAll();

        // Vérifie la date et l'heure de livraison
        $tabHoraire = $horaireRepository->findBySociete(1);

        $day_cmd = date('N', strtotime($commande_date));
        foreach ($tabHoraire as $horaire) {
            if ($horaire['id'] == $day_cmd) {
                if ($horaire['ferme']) {
                    $erreur = "Désolé, nous sommes fermé le " . $horaire['jour'];
                }
                if ($commande_heure < $horaire['ouverture'] && $commande_heure >= $horaire['fermeture']) {
                    $erreur = "heure souhaité hors des horaires d'ouverture du " . $horaire['jour'];
                }

                if ($erreur != "") {
                    $this->addFlash('danger', $erreur);
                    return $this->render('commande/ajout.html.twig', [
                        'utilisateur' => $utilisateur,
                        'tabMenu' => $menus,
                        'menu' => $menu_commande,
                        'plats_menu' => $plats_menu,
                        'plat_types' => $plat_types,
                        'quantite' => $quantite,
                    ]);
                }
            }
        }

        // Vérifier les tarifs



        // Ajouter la commande en bdd
        $numero = $commandeRepository->getNumero();
        $commande = new Commande(
            0,
            $utilisateur_id,
            $menu_id,
            1,
            $numero,
            new DateTime($commande_date),
            0,
            0,
            new DateTime()
        );

        $commande_id = $commandeRepository->insert($commande);
        if (is_array($commande_id))
        {
            $this->addFlash('danger', "Erreur lors de l'enregistrement de la commande : " . $commande_id['message']);
            return $this->render('commande/ajout.html.twig', [
                'menu' => $menu,
                'quantite' => $quantite,
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
                                Montant total : {$commande->getMontant_ht()} €<br>
                                <br>
                                Vous recevrez un nouvel e-mail dès que votre commande sera expédiée ou prête à être livrée.
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

        return $this->redirectToRoute('commande_historique', [
            'id' => $commande_id,
        ]);
    }

    #[Route('/historique/{id}', name: 'historique')]
    public function historique(int $id, CommandeRepository $commandeRepository, GeneriqueRepository $generiqueRepository, MenuRepository $menuRepository, Security $security): Response
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
            return new JsonResponse(['error' => 'Menu introuvable'], Response::HTTP_NOT_FOUND);
        }

        $plats_menu = $platRepository->findByMenuId($menu->getId());
        $plat_types = $platTypeRepository->findAll();

        return new JsonResponse([
            'quantite'   => $menu->getQuantite(),
            'conditions' => $menu->getConditions(),
            'composition_menu' => $this->renderView('commande/_composition_menu.html.twig', ['plats_menu' => $plats_menu, 'plat_types' => $plat_types]),
         ]);
    }

}

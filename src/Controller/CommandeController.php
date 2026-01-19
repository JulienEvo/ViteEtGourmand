<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/commande', name: 'commande_')]
class CommandeController extends AbstractController
{
    #[Route('/ajout', name: 'ajout')]
    public function ajout(MenuRepository $menuRepository, UserRepository $userRepository, GeneriqueRepository $generiqueRepository, Request $request): Response
    {
        $menu_id = $request->query->get('menu_id', 0);
        $quantite = $request->query->get('quantite', 0);

        // Récupère l'utilisateur connecté
        $utilisateur_id = $request->query->get('utilisateur_id', 0);
        $utilisateur = $userRepository->findById($utilisateur_id);

        // Pas d'utilisateur connecté, redirige vers la page de connexion
        if (!$utilisateur)
        {
            return $this->render('security/login.html.twig', [
                'redirect' => 'commande',
                'objet_id' => $menu_id,
            ]);
        }

        $menu = $menuRepository->findById($menu_id);

        return $this->render('commande/ajout.html.twig', [
            'utilisateur' => $utilisateur,
            'menu' => $menu,
            'quantite' => $quantite,
        ]);
    }

    #[Route('/{commande_id}/validation', name: 'validation')]
    public function validation(int $commande_id, CommandeRepository $commandeRepository, UserRepository $userRepository, GeneriqueRepository $generiqueRepository, Request $request): Response
    {
        echo "A FAIRE";


        // Vérifier la date et heure de livraison si dans les horaires de la société


        // Envoi email au client



        return $this->render('??????.html.twig', [
            'id' => $commande_id,
        ]);
    }

}

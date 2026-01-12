<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Entity\MenuImage;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuImageRepository;
use App\Repository\MenuRegimeRepository;
use App\Repository\MenuRepository;
use App\Repository\MenuThemeRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/menus', name: 'admin_menu_')]
class MenuController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(MenuRepository $menuRepository): Response
    {
        $tabMenu = $menuRepository->findAll();

        return $this->render('admin/menu/index.html.twig', ['tabMenu' => $tabMenu]);
    }

    #[Route('/new', name: 'new')]
    public function new(): Response
    {

        /*
            } else {
            //-- CREATE --//

            // Pas de doublons de comptes avec le même email
        if ($userRepository->findByEmail($email) != null)
        {
        $this->addFlash('danger', 'un compte existe déjà avec cet email');
        return $this->redirectToRoute('login', ['email' => $email]);
        }

        $userRepository->insert($menu);
        $this->addFlash('success', 'Employé ajouté avec succès');
        */

        return $this->render('admin/menu/new.html.twig');
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(
        int $id,
        MenuRepository $menuRepository,
        GeneriqueRepository $generiqueRepository,
        MenuThemeRepository $menuThemeRepository,
        MenuRegimeRepository $menuRegimeRepository,
        MenuImageRepository $menuImageRepository,
        Request $request
    ): Response
    {

        // Validation du formulaire
        if ($request->isMethod('POST')) {
            $erreurs = "";

            // Récupère les informations du formulaire
            $menu_theme = $request->request->all('menu_theme');
            $menu_regime = $request->request->all('menu_regime');
            $menu_image = $request->files->all('menu_image');
            $delete_image = $request->request->all('delete_image');

            $menu = new Menu(
                $id,
                trim($request->request->get('titre')),
                trim($request->request->get('description')),
                trim($request->request->get('min_personne')),
                trim($request->request->get('tarif_personne')),
                trim($request->request->get('quantite')),
                trim($request->request->get('actif')),
                $menu_theme,
                $menu_regime,
            );

            // Met à jour le menu
            if (!$menuRepository->update($id, $menu))
            {
                $erreurs .= "Erreur lors de la mise à jour du menu \n";
            }

            // Met à jour les thèmes du menu
            if (!$menuThemeRepository->insert($id, $menu_theme))
            {
                $erreurs .= "Erreur lors de la mise à jour des thèmes du menu \n";
            }

            // Met à jour les régimes du menu
            if (!$menuRegimeRepository->insert($id, $menu_regime))
            {
                $erreurs .= "Erreur lors de la mise à jour des régimes du menu \n";
            }

            // Met à jour les images du menu
            //-- Suppression des images
            $menuImageRepository->delete($delete_image);

            //-- Ajout des images
            foreach ($menu_image as $image)
            {
                //*** VERIFICATION DU FICHIER téléchargé ***//
                $tailleMax = 5 * 1024 * 1024;
                $extensionsValides = [
                    'image/jpeg',
                    'image/png',
                ];

                // Provenance du fichier
                if (!$image instanceof UploadedFile) {
                    continue;
                }
                // Téléchargement réussi
                if (!$image->isValid()) {
                    $erreurs .= 'Erreur lors de l’envoi du fichier : '.$image->getClientOriginalName();
                    continue;
                }
                // Taille Max
                if ($image->getSize() > $tailleMax) {
                    $erreurs .= $image->getClientOriginalName()." dépasse la taille maximale autorisée (5 Mo) \n";
                    continue;
                }
                // Extensions autorisées
                if (!in_array($image->getMimeType(), $extensionsValides, true)) {
                    $erreurs .= $image->getClientOriginalName()." : type de fichier non autorisé \n";
                    continue;
                }

                // Enregistre le fichier dans le dossier uploads
                $fichier = uniqid().'.'.$image->guessExtension();
                $dossier = './documents/menus/'.$menu->getId().'/';

                if (!is_dir($dossier))
                {
                    mkdir($dossier, 0775, true);
                }
                $image->move($dossier, $fichier);

                // Enregistre l'image en bdd
                $menuImageRepository->insert(new MenuImage(
                    0,
                    $menu->getId(),
                    $dossier.$fichier,
                    $image->getClientOriginalName(),
                ));
            }

            if ($erreurs == "")
            {
                $this->addFlash('success', 'Menu modifié avec succès'); // MODIF : Ne marche pas, ajour dans layout.html.twig
            }
            else
            {
                $this->addFlash('danger', $erreurs);
            }

            return $this->redirectToRoute('admin_menu_edit', ['id' => $id]);
        }

        // Récupère le menu par son ID
        $menu = $menuRepository->findById($id);

        // Récupère les images du menu
        $images = $menuImageRepository->findByMenuId($menu->getId());


        // Récupère la liste de thèmes => MODIF : ajouter champs Actif
        $tab_themes = $generiqueRepository->findAll('theme');

        // Récupère la liste de régime => MODIF : ajouter champs Actif
        $tab_regimes = $generiqueRepository->findAll('regime');

        // Affiche le menu
        return $this->render('admin/menu/edit.html.twig', [
            'id' => $id,
            'menu' => $menu,
            'images' => $images,
            'tab_themes' => $tab_themes,
            'tab_regimes' => $tab_regimes,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        return $this->redirectToRoute('admin_menu_index');
    }
}

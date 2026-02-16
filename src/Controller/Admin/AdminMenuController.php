<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Repository\AvisRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuPlatRepository;
use App\Repository\MenuRegimeRepository;
use App\Repository\MenuRepository;
use App\Repository\MenuThemeRepository;
use App\Repository\PlatRepository;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/menus', name: 'admin_menu_')]
class AdminMenuController extends AbstractController
{

    #[Route('/', name: 'index')]
    public function index(MenuRepository $menuRepository): Response
    {
        $tabMenu = $menuRepository->findAll();

        return $this->render('admin/menu/index.html.twig', [
            'tabMenu' => $tabMenu,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(
        int $id,
        MenuRepository $menuRepository,
        GeneriqueRepository $generiqueRepository,
        MenuThemeRepository $menuThemeRepository,
        MenuRegimeRepository $menuRegimeRepository,
        PlatRepository $platRepository,
        MenuPlatRepository $menuPlatRepository,
        AvisRepository $avisRepository,
        UserRepository $userRepository,
        Request $request
    ): Response
    {
        $comeFrom = $request->query->get('comeFrom', '');

        //--- VALIDATION DU FORMULAIRE ---//
        if ($request->isMethod('POST')) {

            switch ($comeFrom) {
                default :
                    $erreurs = "";

                    // Récupère les informations du formulaire
                    $menu_theme = $request->request->all('menu_theme');
                    $menu_regime = $request->request->all('menu_regime');
                    $suppr_plat = $request->request->all('SUPPR_PLAT');

                    $menu = new Menu(
                        $id,
                        trim($request->request->get('libelle')),
                        trim($request->request->get('description')),
                        trim($request->request->get('conditions')),
                        $request->request->get('quantite_min'),
                        $request->request->get('tarif_unitaire'),
                        $request->request->get('quantite_disponible'),
                        $request->request->get('pret_materiel'),
                        $request->request->get('actif'),
                        implode($menu_theme),
                        implode($menu_regime),
                    );

                    // Enregistre le menu
                    if ($id == 0)
                    {
                        $new_id = $menuRepository->insert($menu);
                        if (!$new_id)
                        {
                            $erreurs .= "Erreur lors de l'ajout du menu \n";
                        }
                        else{
                            $id = $new_id;
                        }
                    }
                    else
                    {
                        if (!$menuRepository->update($id, $menu))
                        {
                            $erreurs .= "Erreur lors de la mise à jour du menu \n";
                        }
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

                    // Supprime les plats sélectionnés
                    foreach ($suppr_plat as $plat_id => $statut)
                    {
                        $menuPlatRepository->delete($id, $plat_id);
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

                    break;
                case 'plat':
                    $erreurs = '';

                    // Ajoute les plats sélectionnés au menu
                    $tab_plats = $request->request->all('PLATS');

                    foreach ($tab_plats as $plat_id => $statut)
                    {
                        if (!$menuPlatRepository->insert($id, $plat_id))
                        {
                            $erreurs .= "Plat N°" . $plat_id . " non enregistré <br>";
                        }
                    }

                    if ($erreurs == "")
                    {
                        $this->addFlash('success', count($tab_plats) . ' plat(s) ajouté(s) avec succès'); // MODIF : Ne marche pas, ajour dans layout.html.twig
                    }
                    else
                    {
                        $this->addFlash('danger', $erreurs);
                    }

                    return $this->redirectToRoute('admin_menu_edit', ['id' => $id]);

                    break;
            }
        }

        // Récupère le menu par son ID
        $menu = $menuRepository->findById($id);
        $menu_id = (isset($menu)) ? $menu->getId():0;

        // Récupère les plats du menu
        $plats = $platRepository->findByMenuId($menu_id);

        // Récupère les images des plats du menu
        $tab_images = $platRepository->findImagesByMenuId($menu_id);

        // Récupère la liste de thèmes => MODIF : ajouter champs Actif
        $tab_themes = $generiqueRepository->findAll('theme');

        // Récupère la liste de régime => MODIF : ajouter champs Actif
        $tab_regimes = $generiqueRepository->findAll('regime');

        // Récupère la liste des avis clients du menu
        $tab_avis = $avisRepository->findByMenuId($menu_id);

        // Récupère la liste des utilisateurs
        $tab_utilisateur = $userRepository->findAll();


        // Affiche le menu
        return $this->render('admin/menu/edit.html.twig', [
            'id' => $id,
            'menu' => $menu,
            'tab_images' => $tab_images,
            'tab_themes' => $tab_themes,
            'tab_regimes' => $tab_regimes,
            'plats' => $plats,
            'tab_avis' => $tab_avis,
            'tab_utilisateur' => $tab_utilisateur,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(int $id, MenuRepository $menuRepository): Response
    {
        $ret = $menuRepository->delete($id);

        if ($ret)
        {
            $this->addFlash('success', 'Menu supprimé avec succès');
        }
        else
        {
            $this->addFlash('danger', 'Une erreur est survenue lors de la suppression du menu : '.$ret);
        }

        return $this->redirectToRoute('admin_menu_index');
    }
}

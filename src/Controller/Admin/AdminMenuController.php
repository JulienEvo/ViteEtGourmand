<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuPlatRepository;
use App\Repository\MenuRegimeRepository;
use App\Repository\MenuRepository;
use App\Repository\MenuThemeRepository;
use App\Repository\PlatRepository;
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
                        trim($request->request->get('titre')),
                        trim($request->request->get('description')),
                        trim($request->request->get('conditions')),
                        trim($request->request->get('quantite_min')),
                        trim($request->request->get('tarif_unitaire')),
                        trim($request->request->get('quantite_disponible')),
                        trim($request->request->get('actif')),
                        implode($menu_theme),
                        implode($menu_regime),
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

        // Récupère les images des plats du menu
        $tab_images = $platRepository->findImagesByMenuId($menu->getId());

        // Récupère la liste de thèmes => MODIF : ajouter champs Actif
        $tab_themes = $generiqueRepository->findAll('theme');

        // Récupère la liste de régime => MODIF : ajouter champs Actif
        $tab_regimes = $generiqueRepository->findAll('regime');

        // Récupère les plats du menu
        $plats = $platRepository->findByMenuId($menu->getId());

        // Affiche le menu
        return $this->render('admin/menu/edit.html.twig', [
            'id' => $id,
            'menu' => $menu,
            'tab_images' => $tab_images,
            'tab_themes' => $tab_themes,
            'tab_regimes' => $tab_regimes,
            'plats' => $plats,
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

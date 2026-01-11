<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Repository\GeneriqueRepository;
use App\Repository\MenuRegimeRepository;
use App\Repository\MenuRepository;
use App\Repository\MenuThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        Request $request
    ): Response
    {
        // Validation du formulaire
        if ($request->isMethod('POST')) {

            $menu = new Menu();
            $menu->setTitre(trim($request->request->get('titre')));
            $menu->setDescription(trim($request->request->get('description')));
            $menu->setMinPersonne(trim($request->request->get('min_personne')));
            $menu->setTarifPersonne(trim($request->request->get('tarif_personne')));
            $menu->setQuantite(trim($request->request->get('quantite')));
            $menu->setActif(trim($request->request->get('actif')));

            // Met à jour le menu
            $res = $menuRepository->update($id, $menu);

            // Met à jour les thèmes du menu
            $menuThemeRepository->insert($id, $request->request->all('themes'));

            // Met à jour les régimes du menu
            $menuRegimeRepository->insert($id, $request->request->all('regimes'));


            if ($res)
            {
                $this->addFlash('success', 'Menu modifié avec succès'); // MODIF : Ne marche pas, ajour dans layout.html.twig
                return $this->redirectToRoute('admin_menu_edit', ['id' => $id]);
            }
            else
            {
                $this->addFlash('danger', 'Erreur lors de la modification du menu');
                return $this->redirectToRoute('admin_menu_index');
            }
        }

        // Récupère le menu par son ID
        $menu = $menuRepository->findById($id);

        /*
        // Récupère les thèmes du menu
        $menu_theme = $menuThemeRepository->findAll(" AND menu_id = :menu_id", ["menu_id" => $id]);

        // Récupère les régimes du menu
        $menu_regime = $menuRegimeRepository->findAll(" AND menu_id = :menu_id", ["menu_id" => $id]);

        // Récupère les images du menu
        */

        // Récupère la liste de thèmes => MODIF : ajouter champs Actif
        $tab_theme = $generiqueRepository->findAll('theme');

        // Récupère la liste de régime => MODIF : ajouter champs Actif
        $tab_regime = $generiqueRepository->findAll('regime');

        // Affiche le menu
        return $this->render('admin/menu/edit.html.twig', [
            'id' => $id,
            'menu' => $menu,
            'menu_themes' => $menu->getThemes(),
            'menu_regimes' => $menu->getRegime(),
            'menu_images' => $menu->getImages(),
            'tab_theme' => $tab_theme,
            'tab_regime' => $tab_regime,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(int $id): Response
    {
        return $this->redirectToRoute('admin_menu_index');
    }
}

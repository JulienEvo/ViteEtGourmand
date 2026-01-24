<?php

namespace App\Repository;

use App\Entity\Menu;
use PDO;

class MenuRepository
{
    protected PDO $pdo;
    private MenuThemeRepository $menuThemeRepository;
    private MenuRegimeRepository $menuRegimeRepository;
    private PlatRepository $platRepository;

    public function __construct(
        PDO $pdo,
        MenuThemeRepository $menuThemeRepository,
        MenuRegimeRepository $menuRegimeRepository,
        PlatRepository $platRepository,
    )
    {
        $this->pdo = $pdo;
        $this->menuThemeRepository = $menuThemeRepository;
        $this->menuRegimeRepository = $menuRegimeRepository;
        $this->platRepository = $platRepository;
    }

    public function insert(array $menu): bool
    {
        $sql = "INSERT INTO menu (libelle, description, conditions, theme, min_personne, tarif_personne, regime, quantite, actif)
                VALUES (:libelle, :description, :conditions, :theme, :min_personne, :tarif_personne, :regime, :quantite, :actif)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':libelle' => $menu['libelle'],
            ':description' => $menu['description'],
            ':conditions' => $menu['conditions'],
            ':theme' => $menu['theme'],
            ':min_personne' => $menu['min_personne'],
            ':tarif_personne' => $menu['tarif_personne'],
            ':regime' => $menu['regime'],
            ':quantite' => $menu['quantite'],
            ':actif' => $menu['actif'] ?? 1
        ]);
    }

    public function update(int $id, Menu $menu): bool
    {
        // Met à jour le menu
        $sql = "UPDATE menu
                SET libelle = :libelle,
                    description = :description,
                    conditions = :conditions,
                    min_personne = :min_personne,
                    tarif_personne = :tarif_personne,
                    quantite = :quantite,
                    actif = :actif
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':libelle' => $menu->getLibelle(),
            ':description' => $menu->getDescription(),
            ':conditions' => $menu->getConditions(),
            ':min_personne' => $menu->getMin_personne(),
            ':tarif_personne' => $menu->getTarif_personne(),
            ':quantite' => $menu->getQuantite(),
            ':actif' => $menu->isActif(),
            ':id' => $id
        ]);

        // Met à jour les thèmes du menu
        // ...

        // Met à jour les régimes du menu
    }

    public function delete(int $menu_id): bool
    {
        $sql = "UPDATE menu
                SET actif = 0
                WHERE id = :menu_id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':menu_id' => $menu_id]);
    }

    public function findAll($only_actif = false): array
    {
        $sql = "SELECT menu.*,
                    IFNULL((
                        SELECT GROUP_CONCAT(theme.libelle SEPARATOR ', ')
                        FROM menu_theme
                        JOIN theme ON theme.id = menu_theme.theme_id
                        WHERE menu_theme.menu_id = menu.id
                    ), '') AS themes,
                    IFNULL((
                        SELECT GROUP_CONCAT(regime.libelle SEPARATOR ', ')
                        FROM menu_regime
                        JOIN regime ON regime.id = menu_regime.regime_id
                        WHERE menu_regime.menu_id = menu.id
                    ), '') AS regimes
                FROM menu";

        if ($only_actif)
        {
            $sql .= " WHERE actif = 1";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $tabMenus = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $tabMenus[$row['id']] = new Menu(
                $row['id'],
                $row['libelle'],
                $row['description'],
                $row['conditions'],
                $row['min_personne'],
                $row['tarif_personne'],
                $row['quantite'],
                $row['actif'],
                $row['themes'],
                $row['regimes'],
            );
        }

        return $tabMenus;
    }

    public function findById(int $menu_id): ?Menu
    {
        $menu = null;
        $themes  = $this->menuThemeRepository->findAllIdByMenuId($menu_id);
        $regimes = $this->menuRegimeRepository->findAllIdByMenuId($menu_id);

        $sql = "SELECT *
                FROM menu
                WHERE id = :menu_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':menu_id' => $menu_id]);

        if ($stmt->rowCount() > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $menu = new Menu(
                $row['id'],
                $row['libelle'],
                $row['description'],
                $row['conditions'],
                $row['min_personne'],
                $row['tarif_personne'],
                $row['quantite'],
                $row['actif'],
                implode($themes),
                implode($regimes)
            );
        }

        return $menu;
    }

    public function findByFilters(array $filters): array
    {
        $vars = [];
        $sql = "SELECT DISTINCT(menu.id), menu.*
                FROM menu
                LEFT OUTER JOIN menu_theme ON menu_theme.menu_id = menu.id
                LEFT OUTER JOIN theme ON theme.id = menu_theme.theme_id
                LEFT OUTER JOIN menu_regime ON menu_regime.menu_id = menu.id
                LEFT OUTER JOIN regime ON regime.id = menu_regime.regime_id
                WHERE 1 ";

        if (!empty($filters['term'])) {
            $sql .= " AND
                        (
                            menu.libelle LIKE :term
                            OR
                            menu.description LIKE :term
                            OR
                            menu.conditions LIKE :term
                        )";
            $vars[':term'] = "%" . $filters['term'] . "%";
        }

        if (!empty($filters['theme'])) {
            $sql .= " AND menu_theme.theme_id iN (:theme)";
            $vars[':theme'] = $filters['theme'];
        }

        if (!empty($filters['regime'])) {
            $sql .= " AND menu_regime.regime_id iN (:regime)";
            $vars[':regime'] = $filters['regime'];
        }

        if (!empty($filters['tarif_min'])) {
            $sql .= " AND menu.tarif_personne >= :tarif_min";
            $vars[':tarif_min'] = $filters['tarif_min'];
        }

        if (!empty($filters['tarif_max'])) {
            $sql .= " AND menu.tarif_personne <= :tarif_max";
            $vars[':tarif_max'] = $filters['tarif_max'];
        }

        if (!empty($filters['disponible'])) {
            $sql .= " AND menu.quantite > 0";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($vars);

        $menus = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $menus[$row['id']] = $row;
            $menus[$row['id']]['themes'] = $this->menuThemeRepository->findAllLibelleByMenuId($row['id']);
            $menus[$row['id']]['regimes'] = $this->menuRegimeRepository->findAllLibelleByMenuId($row['id']);
            $menus[$row['id']]['images'] = $this->platRepository->findImagesByMenuId($row['id']);
        }

        return $menus;
    }

}

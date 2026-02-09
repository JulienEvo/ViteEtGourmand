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

    public function insert(Menu $menu): false|int
    {
        $sql = "INSERT INTO menu (libelle, description, conditions, quantite_min, tarif_unitaire, quantite_disponible, pret_materiel, actif)
                VALUES (:libelle, :description, :conditions, :quantite_min, :tarif_unitaire, :quantite_disponible, :pret_materiel, :actif)";

        $stmt = $this->pdo->prepare($sql);

        $retour = $stmt->execute([
            ':libelle' => $menu->getLibelle(),
            ':description' => $menu->getDescription(),
            ':conditions' => $menu->getConditions(),
            ':quantite_min' => $menu->getQuantite_min(),
            ':tarif_unitaire' => $menu->getTarif_unitaire(),
            ':quantite_disponible' => $menu->getQuantite_disponible(),
            ':pret_materiel' => $menu->getPret_materiel(),
            ':actif' => ($menu->isActif()) ?? 1
        ]);

        if ($retour)
        {
            // INSERT réussi : on renvoie l'ID du menu
            $retour = $this->pdo->lastInsertId();
        }

        return $retour;
    }

    public function update(int $id, Menu $menu): bool
    {
        // Met à jour le menu
        $sql = "UPDATE menu
                SET libelle = :libelle,
                    description = :description,
                    conditions = :conditions,
                    quantite_min = :quantite_min,
                    tarif_unitaire = :tarif_unitaire,
                    quantite_disponible = :quantite_disponible,
                    pret_materiel = :pret_materiel,
                    actif = :actif
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':libelle' => $menu->getLibelle(),
            ':description' => $menu->getDescription(),
            ':conditions' => $menu->getConditions(),
            ':quantite_min' => $menu->getquantite_min(),
            ':tarif_unitaire' => $menu->gettarif_unitaire(),
            ':quantite_disponible' => $menu->getQuantite_disponible(),
            ':pret_materiel' => $menu->getPret_materiel(),
            ':actif' => $menu->isActif(),
            ':id' => $id
        ]);

        // Met à jour les thèmes du menu
        // ...

        // Met à jour les régimes du menu
    }

    public function delete(int $menu_id): bool|array
    {
        $sql = "UPDATE menu
                SET actif = 0
                WHERE id = :menu_id";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute([':menu_id' => $menu_id]))
        {
            return true;
        }
        else
        {
            return $stmt->errorInfo();
        }
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
                $row['quantite_min'],
                $row['tarif_unitaire'],
                $row['quantite_disponible'],
                $row['pret_materiel'],
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
                $row['quantite_min'],
                $row['tarif_unitaire'],
                $row['quantite_disponible'],
                $row['pret_materiel'],
                $row['actif'],
                implode($themes),
                implode($regimes)
            );
        }

        return $menu;
    }

    public function findByCommandeId(int $commande_id): ?Menu
    {
        $menu = null;

        $sql = "SELECT *
                FROM menu
                LEFT OUTER JOIN commande ON commande.menu_id = menu.id
                WHERE commande.id = :commande_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':commande_id' => $commande_id]);

        if ($stmt->rowCount() > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $menu = new Menu(
                $row['id'],
                $row['libelle'],
                $row['description'],
                $row['conditions'],
                $row['quantite_min'],
                $row['tarif_unitaire'],
                $row['quantite_disponible'],
                $row['pret_materiel'],
                $row['actif'],
                implode($this->menuThemeRepository->findAllIdByMenuId($row['id'])),
                implode($this->menuRegimeRepository->findAllIdByMenuId($row['id']))
            );
        }

        return $menu;
    }

    public function findByFilters(array $filters): array
    {
        $vars = [];
        $sql = "SELECT menu.*
                FROM menu
                LEFT JOIN menu_theme ON menu_theme.menu_id = menu.id
                LEFT JOIN theme ON theme.id = menu_theme.theme_id
                LEFT JOIN menu_regime ON menu_regime.menu_id = menu.id
                LEFT JOIN regime ON regime.id = menu_regime.regime_id
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
            $sql .= " AND menu.tarif_unitaire >= :tarif_min";
            $vars[':tarif_min'] = $filters['tarif_min'];
        }

        if (!empty($filters['tarif_max'])) {
            $sql .= " AND menu.tarif_unitaire <= :tarif_max";
            $vars[':tarif_max'] = $filters['tarif_max'];
        }

        if (!empty($filters['pers_min'])) {
            $sql .= " AND menu.quantite_min <= :pers_min AND quantite_disponible >= :pers_min";
            $vars[':pers_min'] = $filters['pers_min'];
        }

        if (!empty($filters['disponible'])) {
            $sql .= " AND menu.actif = 1 AND menu.quantite_disponible > 0";
        }

        $sql .= " GROUP BY menu.id";

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

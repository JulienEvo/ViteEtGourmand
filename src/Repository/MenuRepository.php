<?php

namespace App\Repository;

use App\Entity\Menu;
use PDO;

class MenuRepository
{
    protected PDO $pdo;
    private MenuThemeRepository $menuThemeRepository;
    private MenuRegimeRepository $menuRegimeRepository;

    public function __construct(
        PDO $pdo,
        MenuThemeRepository $menuThemeRepository,
        MenuRegimeRepository $menuRegimeRepository,
    )
    {
        $this->pdo = $pdo;
        $this->menuThemeRepository = $menuThemeRepository;
        $this->menuRegimeRepository = $menuRegimeRepository;
    }

    public function insert(array $menu): bool
    {
        $sql = "INSERT INTO menu (titre, description, theme, min_personne, tarif_personne, regime, quantite, actif)
                VALUES (:titre, :description, :theme, :min_personne, :tarif_personne, :regime, :quantite, :actif)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titre' => $menu['titre'],
            ':description' => $menu['description'],
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
                SET titre = :titre,
                    description = :description,
                    min_personne = :min_personne,
                    tarif_personne = :tarif_personne,
                    quantite = :quantite,
                    actif = :actif
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':titre' => $menu->getTitre(),
            ':description' => $menu->getDescription(),
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

    public function findAll(): array
    {
        $sql = "SELECT *
                FROM menu
                WHERE 1 ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $menu_id): Menu
    {
        $sql = "SELECT *
                FROM menu
                WHERE id = :menu_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':menu_id' => $menu_id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $themes  = $this->menuThemeRepository->findAllByMenuId($menu_id);
        $regimes = $this->menuRegimeRepository->findAllByMenuId($menu_id);

        return new Menu(
            $row['id'],
            $row['titre'],
            $row['description'],
            $row['min_personne'],
            $row['tarif_personne'],
            $row['quantite'],
            $row['actif'],
            $themes,
            $regimes,
        );
    }

    public function findByFilters(array $filters): array
    {
        $vars = [];
        $sql = "SELECT *
                FROM menu
                WHERE 1 ";

        if (!empty($filters['q'])) {
            $sql .= " AND titre LIKE :q";
            $vars['q'] = "%" . $filters['q'] . "%";
        }

        if (!empty($filters['category'])) {
            $sql .= " AND titre LIKE :q";
            $vars['q'] = "%" . $filters['q'] . "%";
        }

        if (!empty($filters['tarif_max'])) {
            $sql .= " AND titre LIKE :q";
            $vars['q'] = "%" . $filters['q'] . "%";
        }


        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($vars);

        return $stmt->fetchAll();
    }

}

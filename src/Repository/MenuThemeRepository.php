<?php

namespace App\Repository;

use App\Service\FonctionsService;
use PDO;

class MenuThemeRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(int $menu_id, array $tab_theme): bool
    {
        $this->delete($menu_id);

        foreach ($tab_theme as $theme_id)
        {
            $sql = "INSERT INTO menu_theme (menu_id, theme_id)
                    VALUES (:menu_id, :theme_id)";
            $stmt = $this->pdo->prepare($sql);

            $res = $stmt->execute([
                ':menu_id' => $menu_id,
                ':theme_id' => $theme_id
            ]);

            if (!$res)
            {
                return false;
            }
        }

        return true;
    }

    public function delete(int $menu_id): bool
    {
        $sql = "DELETE FROM menu_theme WHERE menu_id = :menu_id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['menu_id' => $menu_id]);
    }

    public function findAllIdByMenuId($menu_id): array
    {
        $retour = [];

        $sql = "SELECT theme_id
                FROM menu_theme
                WHERE menu_id = :menu_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['menu_id' => $menu_id]);

        while ($row = $stmt->fetch())
        {
            $retour[] = $row['theme_id'];
        }

        return $retour;
    }

    public function findAllLibelleByMenuId($menu_id): array
    {
        $retour = [];

        $sql = "SELECT theme.libelle
                FROM theme
                INNER JOIN menu_theme ON menu_theme.theme_id = theme.id
                WHERE menu_theme.menu_id = :menu_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['menu_id' => $menu_id]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $retour[] = $row['libelle'];
        }

        return $retour;
    }

}

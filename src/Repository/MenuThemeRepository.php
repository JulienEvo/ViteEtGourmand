<?php

namespace App\Repository;

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
            $sql = "INSERT INTO {$this->table} (menu_id, theme_id)
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
        $sql = "DELETE FROM {$this->table} WHERE menu_id = :menu_id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['menu_id' => $menu_id]);
    }

    public function findByMenuId($menu_id): array
    {
        $sql = "SELECT *
                FROM menu_theme
                WHERE menu_id = :menu_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['menu_id' => $menu_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

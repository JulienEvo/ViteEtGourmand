<?php

namespace App\Repository;

use PDO;

class MenuPlatRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(int $menu_id, int $plat_id): bool
    {
        if ($this->MenuPlatExiste($menu_id, $plat_id)) {
            return true;
        }

        $sql = "INSERT INTO menu_plat (menu_id, plat_id)
            VALUES (:menu_id, :plat_id)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':menu_id' => $menu_id,
            ':plat_id' => $plat_id
        ]);
    }

    public function delete(int $menu_id, int $plat_id = 0): bool
    {
        $vars = ['menu_id' => $menu_id];
        $sql = "DELETE FROM menu_plat
                WHERE menu_id = :menu_id";
        if ($plat_id > 0)
        {
            $sql .= " AND plat_id = :plat_id";
            $vars['plat_id'] = $plat_id;
        }
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($vars);
    }

    public function MenuPlatExiste(int $menu_id, int $plat_id): bool
    {
        $sql = "SELECT *
                FROM menu_plat
                WHERE menu_id = :menu_id AND plat_id = :plat_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['menu_id' => $menu_id, 'plat_id' => $plat_id]);

        return ($stmt->rowCount() > 0);
    }

}

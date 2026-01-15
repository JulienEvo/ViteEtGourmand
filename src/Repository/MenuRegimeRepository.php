<?php

namespace App\Repository;

use PDO;
class MenuRegimeRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(int $menu_id, array $tab_regime): bool
    {
        $this->delete($menu_id);

        foreach ($tab_regime as $regime_id)
        {
            $sql = "INSERT INTO menu_regime (menu_id, regime_id)
                    VALUES (:menu_id, :regime_id)";
            $stmt = $this->pdo->prepare($sql);

            $res = $stmt->execute([
                ':menu_id' => $menu_id,
                ':regime_id' => $regime_id
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
        $sql = "DELETE FROM menu_regime WHERE menu_id = :menu_id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(['menu_id' => $menu_id]);
    }

    public function findAllIdByMenuId($menu_id): array
    {
        $retour = [];

        $sql = "SELECT regime_id
                FROM menu_regime
                WHERE menu_id = :menu_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['menu_id' => $menu_id]);

        while ($row = $stmt->fetch())
        {
            $retour[] = $row['regime_id'];
        }

        return $retour;
    }

    public function findAllLibelleByMenuId($menu_id): array
    {
        $retour = [];

        $sql = "SELECT regime.libelle
                FROM regime
                INNER JOIN menu_regime ON menu_regime.regime_id = regime.id
                WHERE menu_regime.menu_id = :menu_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['menu_id' => $menu_id]);

        while ($row = $stmt->fetch())
        {
            $retour[] = $row['libelle'];
        }

        return $retour;
    }

}

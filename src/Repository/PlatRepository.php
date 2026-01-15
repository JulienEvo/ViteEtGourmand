<?php

namespace App\Repository;

use App\Entity\Plat;
use PDO;

class PlatRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Plat $plat): bool
    {
        $sql = "INSERT INTO plat (libelle, type_id, image, actif)
                VALUES (:libelle, :type_id, :image, :actif)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $plat->getLibelle(),
            'type_id' => $plat->getType_id(),
            'image' => $plat->getImage(),
            'actif' => 1
        ]);
    }

    public function update(Plat $plat): bool
    {
        $sql = "UPDATE plat
                SET libelle=:libelle, type_id=:type_id, image=:image, actif=:actif
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'libelle' => $plat->getLibelle(),
            'type_id' => $plat->getType_id(),
            'image' => $plat->getImage(),
            'actif' => $plat->isActif(),
            'id' => $plat->getId()
        ]);
    }

    public function delete(int $plat_id): bool
    {
        $sql = "DELETE FROM plat
                WHERE id = :plat_id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':plat_id' => $plat_id]);
    }

    public function findAll(): array
    {
        $sql = "SELECT plat.*, plat_type.libelle AS type_libelle
                FROM plat
                INNER JOIN plat_type ON plat_type.id = plat.type_id
                ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): Plat
    {
        $sql = "SELECT *
                FROM plat
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Plat(
                $row['id'],
                $row['libelle'],
                $row['type_id'],
                $row['image'],
                $row['actif']
        );
    }

    public function findByMenuId(int $menu_id): array
    {
        $sql = "SELECT plat.*, plat_type.libelle AS plat_type_libelle
                FROM plat
                INNER JOIN menu_plat ON plat.id = menu_plat.plat_id
                INNER JOIN plat_type ON plat_type.id = plat.type_id
                WHERE menu_plat.menu_id = :menu_id
                ORDER BY plat.type_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':menu_id' => $menu_id]);

        $tab_plat = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $plat = array (
                'id' => $row['id'],
                'libelle' => $row['libelle'],
                'type_id' => $row['type_id'],
                'image' => $row['image'],
                'actif' => $row['actif'],
                'plat_type_libelle' => $row['plat_type_libelle'],
            );

            $tab_plat[] = $plat;
        }

        return $tab_plat;
    }

    public function findImagesByMenuId(int $menu_id): array
    {
        $sql = "SELECT plat.image, plat.libelle AS plat_libelle
                FROM plat
                INNER JOIN menu_plat ON plat.id = menu_plat.plat_id
                WHERE menu_plat.menu_id = :menu_id
                ORDER BY plat.type_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':menu_id' => $menu_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

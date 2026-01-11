<?php

namespace App\Repository;

use App\Entity\MenuImage;
use PDO;

class MenuImageRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(MenuImage $image): bool
    {
        $sql = "INSERT INTO menu_image (menu_id, nom, titre)
                VALUES (:menu_id, :nom, :titre)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'menu_id' => $image->getMenuId(),
            'nom' => $image->getNom(),
            'titre' => $image->getTitre()
        ]);
    }

    public function update(MenuImage $image): bool
    {
        $sql = "UPDATE menu_image
                SET menu_id=:menu_id, nom=:nom, titre=:titre
                WHERE id=:id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'menu_id' => $image->getMenuId(),
            'nom' => $image->getNom()   ,
            'titre' => $image->getTitre(),
            'id' => $image->getId()
        ]);
    }

    public function findByMenuId($menu_id): array
    {
        $sql = "SELECT *
                FROM menu_image
                WHERE menu_id = :menu_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['menu_id' => $menu_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

<?php

namespace App\Repository;

use App\Entity\Societe;
use PDO;
use DateTime;

class SocieteRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /*
    protected function map(array $row): Societe
    {
        return new Societe(
            (int)$row['id'],
            $row['libelle'],
            $row['type'],
            $row['capital'],
            $row['rcs'],
            $row['tva'],
            $row['telephone'],
            $row['email'],
            $row['adresse'],
            $row['code_postal'],
            $row['commune'],
            $row['pays'],
            $row['actif'],
            new \DateTime($row['created_at']),
            $row['updated_at'] ? new \DateTime($row['updated_at']) : null
        );
    }
    */

    public function update(int $id, Societe $societe): bool
    {
        $sql = "UPDATE societe
                SET libelle = :libelle,
                    type = :type,
                    capital = :capital,
                    rcs = :rcs,
                    tva = :tva,
                    telephone = :telephone,
                    email = :email,
                    adresse = :adresse,
                    code_postal = :code_postal,
                    commune = :commune,
                    pays = :pays,
                    actif = :actif
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':libelle' => $societe->getLibelle(),
            ':type' => $societe->getType(),
            ':capital' => $societe->getCapital(),
            ':rcs' => $societe->getRcs(),
            ':tva' => $societe->getTva(),
            ':telephone' => $societe->getTelephone(),
            ':email' => $societe->getEmail(),
            ':adresse' => $societe->getAdresse(),
            ':code_postal' => $societe->getCode_postal(),
            ':commune' => $societe->getCommune(),
            ':pays' => $societe->getPays(),
            ':actif' => $societe->isActif() ?? 1,
            ':id' => $id
        ]);
    }

    public function delete(int $id, bool $definitif = false): bool
    {
        if ($definitif)
        {
            $sql = "DELETE FROM societe WHERE id = :id";
        }
        else
        {
            $sql = "UPDATE societe SET actif = 0 WHERE id = :id";
        }
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([':id' => $id]);
    }

    public function findAll(): array
    {
        $sql = "SELECT *
                FROM societe";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $societe_id): Societe
    {
        $sql = "SELECT *
                FROM societe
                WHERE id = :societe_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':societe_id' => $societe_id]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $societe = new Societe(
            $row['id'],
            $row['libelle'],
            $row['type'],
            $row['capital'],
            $row['rcs'],
            $row['tva'],
            $row['telephone'],
            $row['email'],
            $row['adresse'],
            $row['code_postal'],
            $row['commune'],
            $row['pays'],
            $row['actif'],
            new DateTime($row['created_at']),
            $row['updated_at'] ? new DateTime($row['updated_at']) : null
        );

        return $societe;
    }

}

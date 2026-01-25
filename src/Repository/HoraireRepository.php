<?php

namespace App\Repository;

use App\Entity\Horaire;
use PDO;
use DateTime;

class HoraireRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Horaire $horaire): bool
    {
        $sql = "INSERT INTO horaire (societe_id, jour, ouverture, fermeture, ferme)
                VALUES (:societe_id, :jour, :ouverture, :fermeture, :ferme)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'societe_id' => $horaire->getSocieteId(),
            'jour' => $horaire->getJour(),
            'ouverture' => $horaire->getOuverture()?->format('H:i:s'),
            'fermeture' => $horaire->getFermeture()?->format('H:i:s'),
            'ferme' => $horaire->isFerme() ? 1 : 0
        ]);
    }

    public function update(Horaire $horaire): bool
    {
        $sql = "UPDATE horaire
                SET societe_id=:societe_id, jour=:jour, ouverture=:ouverture, fermeture=:fermeture, ferme=:ferme
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'societe_id' => $horaire->getSociete_id(),
            'jour' => $horaire->getJour(),
            'ouverture' => $horaire->getOuverture()?->format('H:i:s'),
            'fermeture' => $horaire->getFermeture()?->format('H:i:s'),
            'ferme' => $horaire->isFerme() ? 1 : 0,
            'id' => $horaire->getId()
        ]);
    }

    public function findBySociete(int $societe_id): array
    {
        $sql = "SELECT *
                FROM horaire
                WHERE societe_id = :societe_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':societe_id' => $societe_id]);

        $tabHoraire = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $tabHoraire[$row['id']] = new Horaire(
                $row['id'],
                $row['societe_id'],
                $row['jour'],
                new DateTime($row['ouverture']),
                new DateTime($row['fermeture']),
                $row['ferme'],
            );
        }

        return $tabHoraire;
    }

}

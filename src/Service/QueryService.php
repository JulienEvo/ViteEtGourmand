<?php

namespace App\Service;

use PDO;

class QueryService
{
    public function __construct(
        private DatabaseService $database
    ) {}

    public function getSociete(int $societe_id = 1): object
    {
        $stmt = $this->database->getPdo()->prepare(
        '
                SELECT *
                FROM societe
                WHERE societe_id = :societe_id
        ');
        $stmt->bindValue(':societe_id', $societe_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchObject();
    }

    public function getHoraire(int $societe_id = 1): array
    {
        $stmt = $this->database->getPdo()->prepare(
            '
                SELECT *
                FROM horaire
                WHERE societe_id = :societe_id
        ');
        $stmt->bindValue(':societe_id', $societe_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function getLastAvis(int $limit = 10): array
    {
        $stmt = $this->database->getPdo()->prepare(
            '
                SELECT avis_note, avis_html,
                       CONCAT(utilisateur.utilisateur_prenom, " ", UPPER(SUBSTRING(utilisateur.utilisateur_nom, 1, 1)), ".") AS utilisateur_nom
                FROM avis
                INNER JOIN utilisateur ON utilisateur.utilisateur_id = avis.utilisateur_id
                WHERE avis_valide = 1
                LIMIT :limit
        ');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

}

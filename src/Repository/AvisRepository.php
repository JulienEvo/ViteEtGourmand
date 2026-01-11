<?php

namespace App\Repository;

use App\Entity\Avis;
use App\Service\FonctionsService;
use PDO;
USE DateTime;

class AvisRepository extends BaseRepository
{
    protected string $table = 'avis';

    protected function map(array $row): Avis
    {
        return new Avis(
            (int)$row['id'],
            (int)$row['utilisateur_id'],
            (int)$row['note'],
            $row['commentaire'],
            isset($row['valide']) ? (bool)$row['valide'] : null,
            new DateTime($row['created_at'])
        );
    }

    public function insert(Avis $avis): bool
    {
        $sql = "INSERT INTO {$this->table}
                    (utilisateur_id, note, commentaire, valide, created_at)
                VALUES
                    (:uid, :note, :commentaire, :valide, :created)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'uid' => $avis->getUtilisateurId(),
            'note' => $avis->getNote(),
            'commentaire' => $avis->getCommentaire(),
            'valide' => $avis->getValide(),
            'created' => $avis->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function update(Avis $avis): bool
    {
        $sql = "UPDATE {$this->table}
                SET note=:note, commentaire=:commentaire, valide=:valide
                WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            'note' => $avis->getNote(),
            'commentaire' => $avis->getCommentaire(),
            'valide' => $avis->getValide(),
            'id' => $avis->getId()
        ]);
    }

    public function getLastAvis(int $limit = 10): array
    {
        $sql = "SELECT avis.note, avis.commentaire,
                       CONCAT(utilisateur.prenom, ' ', UPPER(SUBSTRING(utilisateur.nom, 1, 1)), '.') AS utilisateur_nom
                FROM avis
                INNER JOIN utilisateur ON utilisateur.id = avis.utilisateur_id
                WHERE avis.valide = 1
                ORDER BY avis.created_at DESC
                LIMIT :limit";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'map'], $rows);
    }

}

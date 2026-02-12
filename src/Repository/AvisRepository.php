<?php

namespace App\Repository;

use App\Entity\Avis;
use App\Entity\Commande;
use PDO;
use DateTime;

class AvisRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(Avis $avis): bool
    {
        $sql = "INSERT INTO avis
                    (utilisateur_id, commande_id, note, commentaire, valide, created_at)
                VALUES
                    (:utilisateur_id, :commande_id, :note, :commentaire, :valide, :created_at)";
        $stmt = $this->pdo->prepare($sql);

        $date = new DateTime();
        return $stmt->execute([
            'utilisateur_id' => $avis->getUtilisateur_id(),
            'commande_id' => $avis->getCommande_id(),
            'note' => $avis->getNote(),
            'commentaire' => $avis->getCommentaire(),
            'valide' => $avis->getValide(),
            'created_at' => $date->format('Y-m-d H:i:s')
        ]);
    }

    public function update(Avis $avis): bool
    {
        $sql = "UPDATE avis
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

    public function findAll(bool $valide_only = false, int $limite = 0): array
    {
        $tabAvis = [];

        $vars = [];
        $sql = "SELECT *
                FROM avis
                WHERE 1";

        if ($valide_only)
        {
            $sql .= " AND valide = :statut_valide";
            $vars['statut_valide'] = Avis::STATUT_VALIDE;
        }

        $sql .= " ORDER BY created_at DESC";

        if ($limite > 0)
        {
            $sql .= " LIMIT ".$limite;
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($vars);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows as $row)
        {
            $tabAvis[$row['id']] = new Avis(
                $row['id'],
                $row['utilisateur_id'],
                $row['commande_id'],
                $row['note'],
                $row['commentaire'],
                $row['valide']
            );
        }

        return $tabAvis;
    }

    public function findById(int $id): ?Avis
    {
        $avis = null;

        $sql = "SELECT *
                FROM avis
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);

        if ($stmt->rowCount() > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $avis = new Avis(
                $row['id'],
                $row['utilisateur_id'],
                $row['commande_id'],
                $row['note'],
                $row['commentaire'],
                $row['valide'],
                new DateTime($row['created_at'])
            );
        }

        return  $avis;
    }

    public function findByParam(int $utilisateur_id = 0, int $commande_id = 0, bool $valide_only = false): array
    {
        $sql = "SELECT avis.*
                FROM avis
                WHERE 1";
        $vars = [];

        if ($utilisateur_id > 0)
        {
            $sql .= " AND utilisateur_id = :utilisateur_id";
            $vars['utilisateur_id'] = $utilisateur_id;
        }
        if ($commande_id > 0)
        {
            $sql .= " AND commande_id = :commande_id";
            $vars['commande_id'] = $commande_id;
        }
        if ($valide_only)
        {
            $sql .= " AND valide = :statut-valide";
            $vars['statut-valide'] = Avis::STATUT_VALIDE;
        }

        $sql .= " ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($vars);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tabAvis = [];
        foreach ($rows as $row)
        {
            $tabAvis[$row['id']] = new Avis(
                $row['id'],
                $row['utilisateur_id'],
                $row['commande_id'],
                $row['note'],
                $row['commentaire'],
                $row['valide'],
                new DateTime($row['created_at'])
            );
        }

        return $tabAvis;
    }

    public function findByMenuId(int $menu_id): array
    {
        $sql = "SELECT avis.*
                FROM avis
                LEFT OUTER JOIN commande ON commande.id = avis.commande_id
                LEFT OUTER JOIN menu ON menu.id = commande.menu_id
                WHERE menu.id = :menu_id
                ORDER BY created_at DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['menu_id' => $menu_id]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $tabAvis = [];
        foreach ($rows as $row)
        {
            $tabAvis[$row['id']] = new Avis(
                $row['id'],
                $row['utilisateur_id'],
                $row['commande_id'],
                $row['note'],
                $row['commentaire'],
                $row['valide'],
                new DateTime($row['created_at'])
            );
        }

        return $tabAvis;
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

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStatAvis(): array
    {
    $sql = "SELECT menu.id AS menu_id,
                menu.libelle AS menu_libelle,
                AVG(avis.note) AS note_moyenne
            FROM avis
            INNER JOIN commande ON commande.id = avis.commande_id
            INNER JOIN menu ON menu.id = commande.menu_id
            WHERE avis.valide = 1
            GROUP BY menu.id, menu.libelle
            ORDER BY note_moyenne DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stat_avis = [];
        foreach ($rows as $row)
        {
            $stat_avis[] = [
                'menu_id' => $row['menu_id'],
                'menu_libelle' => $row['menu_libelle'],
                'note_moyenne' => $row['note_moyenne'],
            ];
        }

        return $stat_avis;
    }

}

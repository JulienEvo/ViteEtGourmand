<?php

namespace App\Repository;

use App\Entity\User;
use App\Service\FonctionsService;
use PDO;
use DateTime;

class UserRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(User $user): int|array
    {
        $sql = "INSERT INTO utilisateur
                    (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, poste, created_at)
                VALUES
                    (:roles, :email, :password, :prenom, :nom, :telephone, :adresse, :code_postal, :commune, :pays, :poste, :created_at)";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute([
            'roles' => json_encode($user->getRoles()),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'prenom' => $user->getPrenom(),
            'nom' => $user->getNom(),
            'telephone' => $user->getTelephone(),
            'adresse' => $user->getAdresse(),
            'code_postal' => $user->getCode_postal(),
            'commune' => $user->getCommune(),
            'pays' => $user->getPays(),
            'poste' => $user->getPoste(),
            'created_at' => date('Y-m-d H:i:s') //$user->getCreatedAt()->format('Y-m-d H:i:s')
        ]))
        {
            return $this->pdo->lastInsertId();
        }
        else{
            return $stmt->errorInfo();
        }
    }

    public function update(User $user, bool $save_pass): bool|array

    {
        $sql = "UPDATE utilisateur
                SET roles=:roles, email=:email, prenom=:prenom, nom=:nom, telephone=:telephone, adresse=:adresse,
                    code_postal=:code_postal, commune=:commune, pays=:pays, poste=:poste, actif=:actif, updated_at=:updated";
        if ($save_pass)
        {
            $sql .= ", password=:password";
        }
        $sql .= " WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        $vars = [
            'roles' => json_encode($user->getRoles()),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'prenom' => $user->getPrenom(),
            'nom' => $user->getNom(),
            'telephone' => $user->getTelephone(),
            'adresse' => $user->getAdresse(),
            'code_postal' => $user->getCode_postal(),
            'commune' => $user->getCommune(),
            'pays' => $user->getPays(),
            'poste' => $user->getPoste(),
            'actif' => $user->getActif(),
            'updated' => date('Y-m-d'),
            'id' => $user->getId()
        ];
        if ($save_pass)
        {
            $vars['password'] = $user->getPassword();
        }

        if ($stmt->execute($vars))
        {
            return true;
        }
        else
        {
            return $stmt->errorInfo();
        }
    }

    public function delete(int $id): bool|array
    {
        $sql = "DELETE FROM utilisateur WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute(['id' => $id]))
        {
            return true;
        }
        else
        {
            return $stmt->errorInfo();
        }
    }

    public function findAll(string $roles = ''): array
    {
        $sql = "SELECT *
                FROM utilisateur
                ORDER BY nom, prenom";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $tabUtilisateur = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if (in_array($roles, json_decode($row['roles'])))
            {
                $tabUtilisateur[$row['id']] = $row;
            }
        }

        return $tabUtilisateur;
    }

    public function findById(int $utilisateur_id): ?User
    {
        $utilisateur = null;

        $sql = "SELECT *
                FROM utilisateur
                WHERE id = :utilisateur_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':utilisateur_id' => $utilisateur_id]);

        if ($stmt->rowCount() > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $utilisateur = new User(
                (int)$row['id'],
                json_decode($row['roles']),
                $row['email'],
                $row['password'],
                $row['prenom'],
                $row['nom'],
                $row['telephone'],
                $row['adresse'],
                $row['code_postal'],
                $row['commune'],
                $row['pays'],
                $row['poste'],
                $row['actif'],
                new DateTime($row['created_at']),
                new DateTime($row['updated_at']),
            );
        }

        return $utilisateur;
    }

    public function findByEmail(string $email): ?User
    {
        $sql = "SELECT *
                FROM utilisateur
                WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return new User(
            $row['id'],
            json_decode($row['roles']),
            $row['email'],
            $row['password'],
            $row['prenom'],
            $row['nom'],
            $row['telephone'],
            $row['adresse'],
            $row['code_postal'],
            $row['commune'],
            $row['pays'],
            $row['poste'],
            $row['actif'],
            new DateTime($row['created_at']),
            new DateTime($row['updated_at'])
        );
    }

    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);
        if (!$user) {
            return null;
        }

        // Vérifie le mot de passe
        if (!password_verify($password, $user->getPassword())) {
            return null;
        }

        // Connexion réussie, retourne les infos essentielles
        return [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'prenom' => $user->getPrenom(),
            'nom' => $user->getNom(),
            'poste' => $user->getPoste(),
            'actif' => $user->getActif(),
            'roles' => $user->getRoles(),
        ];
    }

    public function isValidPassword(string $password): bool
    {
        $regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{10,}$/';
        return preg_match($regex, $password) === 1;
    }


}

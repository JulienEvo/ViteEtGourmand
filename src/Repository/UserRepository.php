<?php

namespace App\Repository;

use App\Entity\User;
use App\Service\FonctionsService;
use PDO;
use DateTime;
use Symfony\Component\Security\Core\User\UserInterface;

class UserRepository
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function insert(User $user): int|array
    {
        $vars = [
            'roles' => json_encode($user->getRoles()),
            'email' => $user->getEmail(),
            'password' => password_hash($user->getPassword(), PASSWORD_DEFAULT),
            'prenom' => $user->getPrenom(),
            'nom' => $user->getNom(),
            'telephone' => $user->getTelephone(),
            'adresse' => $user->getAdresse(),
            'code_postal' => $user->getCode_postal(),
            'commune' => $user->getCommune(),
            'pays' => $user->getPays(),
            'poste' => $user->getPoste(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $sql_ins = '';
        $sql_val = '';
        $latitude = $user->getLatitude();
        $longitude = $user->getLongitude();
        if (isset($latitude) && isset($longitude))
        {
            $sql_ins = "latitude, longitude, ";
            $sql_val = ":latitude, :longitude, ";
            $vars['latitude'] = $user->getLatitude();
            $vars['longitude'] = $user->getLongitude();
        }

        $sql = "INSERT INTO utilisateur
                    (roles, email, password, prenom, nom, telephone, adresse, code_postal, commune, pays, {$sql_ins} poste, created_at)
                VALUES
                    (:roles, :email, :password, :prenom, :nom, :telephone, :adresse, :code_postal, :commune, :pays, {$sql_val} :poste, :created_at)";
        $stmt = $this->pdo->prepare($sql);

        if ($stmt->execute($vars))
        {
            return $this->pdo->lastInsertId();
        }
        else{
            return $stmt->errorInfo();
        }
    }

    public function update(UserInterface $user, bool $save_pass): bool|array

    {
        $vars = [
            ':roles' => json_encode($user->getRoles()),
            ':email' => $user->getEmail(),
            ':prenom' => $user->getPrenom(),
            ':nom' => $user->getNom(),
            ':telephone' => $user->getTelephone(),
            ':adresse' => $user->getAdresse(),
            ':code_postal' => $user->getCode_postal(),
            ':commune' => $user->getCommune(),
            ':pays' => $user->getPays(),
            ':poste' => $user->getPoste(),
            ':actif' => $user->getActif(),
            ':updated' => date('Y-m-d'),
            ':id' => $user->getUserId(),
        ];

        $password = "";
        if ($save_pass)
        {
            $vars['password'] = password_hash($user->getPassword(), PASSWORD_DEFAULT);
            $password = "password=:password,";
        }

        $sql_upl = "";
        $latitude = $user->getLatitude();
        $longitude = $user->getLongitude();
        if (isset($latitude) && $latitude != '' && isset($longitude) && $longitude != '')
        {
            $sql_upl = "latitude=:latitude, longitude=:longitude, ";
            $vars['latitude'] = $user->getLatitude();
            $vars['longitude'] = $user->getLongitude();
        }

        $sql = "UPDATE utilisateur
                SET roles=:roles, email=:email, {$password} prenom=:prenom, nom=:nom, telephone=:telephone, adresse=:adresse,
                    code_postal=:code_postal, commune=:commune, pays=:pays, {$sql_upl} poste=:poste, actif=:actif, updated_at=:updated
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
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

    public function findAll(string $role = ''): array
    {
        switch ($role)
        {
            case 'ROLE_USER':
                $where_sql = " roles NOT LIKE '%ROLE_ADMIN%' AND roles NOT LIKE '%ROLE_EMPLOYE%' ";
                break;
            case 'ROLE_ADMIN':
                $where_sql = " roles NOT LIKE '%ROLE_EMPLOYE%' OR roles LIKE 'ROLE_USER' ";
                break;
            case 'ROLE_EMPLOYE':
                $where_sql = " roles NOT LIKE '%ROLE_ADMIN%' OR roles LIKE 'ROLE_USER' ";
                break;
            default:
                $where_sql = " 1 ";
        }

        $sql = "SELECT *
                FROM utilisateur
                WHERE {$where_sql}
                ORDER BY nom, prenom";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $tabUtilisateur = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($role == "" || in_array($role, json_decode($row['roles'])))
            {
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
                    $row['latitude'],
                    $row['longitude'],
                    $row['poste'],
                    $row['actif'],
                    new DateTime($row['created_at']),
                    new DateTime($row['updated_at']),
                );

                $tabUtilisateur[$row['id']] = $utilisateur;
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
                $row['latitude'],
                $row['longitude'],
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
        $utilisateur = null;

        $sql = "SELECT *
                FROM utilisateur
                WHERE email = :email";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['email' => $email]);

        if ($stmt->rowCount() > 0)
        {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $utilisateur = new User(
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
                $row['latitude'],
                $row['longitude'],
                $row['poste'],
                $row['actif'],
                new DateTime($row['created_at']),
                new DateTime($row['updated_at'])
            );
        }

        return $utilisateur;
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

    public function isValidUtilisateur(UserInterface $utilisateur, bool $isInsert, bool $checkValidPass = true, string $confirmPass = ""): bool|string
    {
        if ($isInsert)
        {
            // Vérifie s'il existe déjà un compte avec cet email
            if ($this->findByEmail($utilisateur->getEmail()))
            {
                return "Un compte existe déjà avec cet e-mail";
            }
        }

        // Vérifie la confirmation du mot de passe
        if ($checkValidPass)
        {
            if (!$this->isValidPassword($utilisateur->getPassword()))
            {
                return "Le mot de passe doit contenir au moins : 10 caractères, 1 minuscule, 1 majuscule, 1 caractère spécial et 1 chiffre";
            }

            if ($confirmPass != $utilisateur->getPassword())
            {
                return "Les mots de passe ne correspondent pas";
            }
        }

        return true;
    }

    public function getRoleByType(string $type)
    {
        switch ($type)
        {
            case 'admin':
                $role = 'ROLE_ADMIN';
                break;
            case 'employe':
                $role = 'ROLE_EMPLOYE';
                break;
            default:
                $role = 'ROLE_USER';
                break;
        }

        return $role;
    }

}

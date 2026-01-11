<?php

namespace App\Service;

use App\Repository\UserRepository;

class UserAuthenticator
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Vérifie si l'email et le mot de passe sont corrects.
     * @return array|null Retourne les infos de l'utilisateur ou null si échec
     */
    public function authenticate(string $email, string $password): ?array
    {
        $user = $this->userRepository->findByEmail($email);
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
            'role' => $user->getRoles(),
        ];
    }
}

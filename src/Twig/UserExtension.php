<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Symfony\Component\HttpFoundation\RequestStack;

class UserExtension extends AbstractExtension
{
    public function __construct(private RequestStack $requestStack) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_admin', [$this, 'isAdmin']),
            new TwigFunction('is_employe', [$this, 'isEmploye']),
        ];
    }

    public function isAdmin(): bool
    {
        $session = $this->requestStack->getSession();
        $user = $session->get('user');

        if (!$user || !isset($user['roles'])) {
            return false;
        }

        return in_array('ROLE_ADMIN', $user['roles'], true);
    }

    public function isEmploye(): bool
    {
        $session = $this->requestStack->getSession();
        $user = $session->get('user');

        if (!$user || !isset($user['roles'])) {
            return false;
        }

        return in_array('ROLE_EMPLOYE', $user['roles'], true);
    }
}

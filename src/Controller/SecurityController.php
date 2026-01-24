<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Config\Security\FirewallConfig\AccessToken\TokenHandler\Oidc\EncryptionConfig;

class SecurityController extends AbstractController
{
    use TargetPathTrait;

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/login', name: 'login', methods: ['GET','POST'])]
    public function login(AuthenticationUtils $authUtils, UserRepository $userRepository, Request $request): Response
    {
        if ($this->getUser()) {
            $this->addFlash('success', "Bienvenue ".$this->getUser()->getPrenom());
            return $this->redirectToRoute('home');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError()
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(Request $request)
    {}

    #[Route('/register', name: 'register')]
    public function register(Request $request, UserRepository $userRepository, CsrfTokenManagerInterface $csrfTokenManager): Response
    {

        if ($request->isMethod('POST')) {
            $token = new CsrfToken('register', $request->request->get('_csrf_token'));
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $confirm = $request->request->get('confirm_password');

            $utilisateur = new User(
                0,
                [$request->request->get('roles', 'ROLE_USER')],
                $request->request->get('email'),
                $password,
                $request->request->get('prenom'),
                $request->request->get('nom'),
                $request->request->get('telephone'),
                $request->request->get('adresse'),
                $request->request->get('code_postal'),
                $request->request->get('commune'),
                $request->request->get('pays'),
                ($request->request->get('poste') ?? '')
            );

            if (!$csrfTokenManager->isTokenValid($token)) {
                $this->addFlash('danger', 'CSRF invalide');
                return $this->render('security/register.html.twig', ['utilisateur' => $utilisateur]);
            }

            $retValid = $userRepository->isValidUtilisateur($utilisateur, true, $confirm);
            if ($retValid !== true)
            {
                $this->addFlash('danger', $retValid);
                return $this->render('security/register.html.twig', ['utilisateur' => $utilisateur]);
            }

            if ($userRepository->insert($utilisateur))
            {
                $this->addFlash('success', 'Compte créé avec succès');
                return $this->render('security/login.html.twig', ['email' => $email]);
            }
            else
            {
                $this->addFlash('danger', 'Échec de la création du compte');
            }
        }

        return $this->render('security/register.html.twig');
    }

}

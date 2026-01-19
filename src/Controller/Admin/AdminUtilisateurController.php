<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/utilisateur', name: 'admin_utilisateur_')]
class AdminUtilisateurController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepository, Request $request): Response
    {
        $type = $request->query->get('type', 'sss');

        switch ($type)
        {
            case 'admin':
                $role = 'ROLE_ADMIN';
                break;
            case 'employe':
                $role = 'ROLE_EMPLOYE';
                break;
            case 'utilisateur':
                $role = 'ROLE_USER';
                break;
            default:
                $role = '';
                break;
        }

        $tabUtilisateur = $userRepository->findAll($role);

        return $this->render('admin/utilisateur/index.html.twig', ['tabUtilisateur' => $tabUtilisateur]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(int $id, UserRepository $userRepository, Request $request): Response
    {
        //--- VALIDATION DU FORMULAIRE ---//
        if ($request->isMethod('POST')) {

            $nom = trim($request->request->get('nom'));
            $prenom = trim($request->request->get('prenom'));
            $email = trim($request->request->get('email'));
            $password = trim($request->request->get('password'));
            $confirm = trim($request->request->get('confirm'));

            if ($password != "")
            {
                if ($userRepository->isValidPassword($password))
                {
                    throw $this->createAccessDeniedException('Le mot de passe doit contenir au moins : 10 caractères, 1 minuscule, 1 majuscule, 1 caractère spécial et 1 chiffre');
                }

                if ($password != $confirm)
                {
                    $this->addFlash('danger', 'Les mots de passe ne correspondent pas');
                    return $this->redirectToRoute('admin_utilisateur_edit', ['id' => $id]);
                }
            }

            $utilisateur = new User(
                $id,
                [$request->request->get('role')],
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $prenom,
                $nom,
                trim($request->request->get('telephone')),
                trim($request->request->get('adresse')),
                trim($request->request->get('code_postal')),
                trim($request->request->get('commune')),
                trim($request->request->get('pays')),
                trim($request->request->get('poste')),
                $request->request->get('actif'),
                new DateTime(),
                new DateTime(),
            );

            if ($id == 0)
            {
                //*** INSERT ***//
                $ret = $userRepository->insert($utilisateur);
                if (!is_array($ret) )
                {
                    $id = $ret;

                    // Envoi d'un mail à l'utilisateur


                    $this->addFlash('success', 'Employé ajouté avec succès');
                }
                else
                {
                    $this->addFlash('danger', "Erreur lors de l'ajout de l'employé : ".$ret['message'] );
                }
            }
            else
            {
                //*** UPDATE ***//
                $userRepository->update($utilisateur, $password != "");
                $this->addFlash('success', 'Employé modifié avec succès');
            }

            return $this->redirectToRoute('admin_utilisateur_edit', ['id' => $id]);
        }

        // Récupère l'employé par son ID
        $utilisateur = $userRepository->findById($id);

        // Affiche l'employé
        return $this->render('admin/utilisateur/edit.html.twig', [
            'id' => $id,
            'utilisateur' => $utilisateur
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(int $id, UserRepository $userRepository): Response
    {
        //= À TESTER avec erreur
        $ret = $userRepository->delete($id);

        if ($ret)
            {
                $this->addFlash('success', 'Employé supprimé avec succès');
            }
        else
            {
                $this->addFlash('danger', 'Une erreur est survenue lors de l’enregistrement : '.$ret);
            }

        return $this->redirectToRoute('admin_utilisateur_index');
    }
}

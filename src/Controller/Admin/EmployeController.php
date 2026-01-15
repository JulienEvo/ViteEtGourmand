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

#[Route('/admin/employe', name: 'admin_employe_')]
class EmployeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(UserRepository $userRepository): Response
    {
        $tabUser = $userRepository->findAll();

        return $this->render('admin/employe/index.html.twig', ['tabUser' => $tabUser]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(int $id, UserRepository $userRepository, Request $request): Response
    {
        // Validation du formulaire ?
        if ($request->isMethod('POST')) {

            $nom = trim($request->request->get('nom'));
            $prenom = trim($request->request->get('prenom'));
            $email = trim($request->request->get('email'));
            $password = password_hash(trim($request->request->get('password')), PASSWORD_DEFAULT);

            $employe = new User(
                $id,
                ['ROLE_USER', 'ROLE_EMPLOYE'],
                $email,
                $password,
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
                $ret = $userRepository->insert($employe);
                if (!is_array($ret) )
                {
                    $id = $ret;
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
                $userRepository->update($employe);
                $this->addFlash('success', 'Employé modifié avec succès');
            }

            return $this->redirectToRoute('admin_employe_edit', ['id' => $id]);
        }

        // Récupère l'employé par son ID
        $employe = $userRepository->findById($id);

        // Affiche l'employé
        return $this->render('admin/employe/edit.html.twig', [
            'id' => $id,
            'employe' => $employe
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

        return $this->redirectToRoute('admin_employe_index');
    }
}

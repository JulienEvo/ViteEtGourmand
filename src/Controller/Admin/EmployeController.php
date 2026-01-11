<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\FonctionsService;
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
            $password = trim($request->request->get('password'));
            if (empty($id))
            {
                // Nouvel employé : MdP par défaut = nom-prénom
                $password = password_hash($nom.'-'.$prenom, PASSWORD_DEFAULT);
            }

            $employe = new User();
            $employe->setId($id);
            $employe->setroles(['ROLE_USER', 'ROLE_EMPLOYE']);
            $employe->setemail($email);
            $employe->setpassword($password);
            $employe->setprenom($prenom);
            $employe->setnom($nom);
            $employe->settelephone(trim($request->request->get('telephone')));
            $employe->setadresse(trim($request->request->get('adresse')));
            $employe->setcode_postal(trim($request->request->get('code_postal')));
            $employe->setcommune(trim($request->request->get('commune')));
            $employe->setpays(trim($request->request->get('pays')));
            $employe->setposte(trim($request->request->get('poste')));
            $employe->setactif(trim($request->request->get('actif')));

            if ($id) {
                //-- UPDATE --//

                $userRepository->update($employe);
                $this->addFlash('success', 'Employé modifié avec succès');
            } else {
                //-- CREATE --//

                // Pas de doublons de comptes avec le même email
                if ($userRepository->findByEmail($email) != null)
                {
                    $this->addFlash('danger', 'un compte existe déjà avec cet email');
                    return $this->redirectToRoute('login', ['email' => $email]);
                }

                $userRepository->insert($employe);
                $this->addFlash('success', 'Employé ajouté avec succès');
            }

            return $this->redirectToRoute('admin_employe_index');
        }

        // Récupère l'employé par son ID
        $employe = $userRepository->findById($id);

        // Affiche l'employé
        return $this->render('admin/employe/edit.html.twig', [
            'id' => $id,
            'employe' => $employe
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'])]
    public function delete(int $id, UserRepository $userRepository): Response
    {
        if ($userRepository->delete($id))
            {
                $this->addFlash('success', 'Employé supprimé avec succès');
            }
        else
            {
                $this->addFlash('danger', 'Une erreur est survenue lors de l’enregistrement');
            }

        return $this->redirectToRoute('admin_employe_index');
    }
}

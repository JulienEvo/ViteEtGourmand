<?php

namespace App\Controller\Admin;

use App\Entity\Plat;
use App\Repository\AllergeneRepository;
use App\Repository\GeneriqueRepository;
use App\Repository\PlatAllergeneRepository;
use App\Repository\PlatRepository;
use App\Repository\PlatTypeRepository;
use App\Service\FonctionsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/plat', name: 'admin_plat_')]
class AdminPlatController extends AbstractController
{

    #[Route('/', name: 'index', )]
    public function index(Request $request, PlatRepository $platRepository): Response
    {
        $menu_id = $request->query->get('menu_id', 0);
        $comeFrom = $request->query->get('comeFrom', 'zzz');

        $tabPlat = $platRepository->findAll();

        return $this->render('admin/plat/index.html.twig', [
            'tabPlat' => $tabPlat,
            'menu_id' => $menu_id,
            'comeFrom' => $comeFrom,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(
        int $id,
        PlatRepository $platRepository,
        PlatTypeRepository $platTypeRepository,
        PlatAllergeneRepository $platAllergeneRepository,
        GeneriqueRepository $generiqueRepository,
        Request $request,
    ): Response
    {
        $erreurs = "";

        // Validation du formulaire
        if ($request->isMethod('POST')) {
            $old_plat = $platRepository->findById($id);
            $image = $old_plat->getImage();

            // Récupère les données du formulaire
            $new_image = $request->files->get('image');
            $removeImage = $request->request->get('remove_image');
            $plat_allergenes = $request->request->all('plat_allergenes');

            $erreur = "";
            if (isset($new_image) && !$removeImage)
            {
                //--- Vérifie l'image ---//
                $erreur = $this->valideImage($new_image);

                if (empty($erreur))
                {
                    // Supprime l'image précédante
                    if (file_exists($old_plat->getImage())) {
                        unlink($old_plat->getImage());
                    }

                    // Enregistre le fichier dans le dossier /images/plats/{plat_id}
                    $fichier = uniqid().'.'.$new_image->guessExtension();
                    $dossier = './images/plats/';
                    $image = $dossier.$fichier;

                    if (!is_dir($dossier))
                    {
                        mkdir($dossier, 0775, true);
                    }
                    $new_image->move($dossier, $fichier);
                }
                else
                {
                    $this->addFlash('danger', $erreur);
                    return $this->redirectToRoute('admin_plat_edit', ['id' => $id]);
                }
            }

            if ($removeImage)
            {
                // Supprime l'image
                if (file_exists($old_plat->getImage())) {
                    unlink($old_plat->getImage());
                }
                $image = '';
            }

            // PLAT
            $plat = new Plat(
                $id,
                trim($request->request->get('libelle')),
                $request->request->get('type_id'),
                $image,
                $request->request->get('actif'),
            );

            // Met à jour le plat
            if ($id == 0)
            {
                $retour = $platRepository->insert($plat);
                $mode = "ajouté";
            }
            else
            {
                $retour = $platRepository->update($plat);
                $mode = "modifié";
            }

            if (is_int($retour))
            {
                $id = $retour;

                // Met à jour les allergènes du plat
                if (!$platAllergeneRepository->insert($id, $plat_allergenes))
                {
                    $erreurs .= "Erreur lors de la mise à jour des allergènes du plat";
                }
            }
            else
            {
                $erreurs = "Erreur lors de l'enregistrement du plat : " . $retour['message'];
            }

            if ($erreurs == "")
            {
                $this->addFlash('success', "Plat {$mode} avec succès");
            }
        else
            {
                $this->addFlash('danger', "Erreur lors de l'enregistrement du plat : " . $erreurs);
            }

            return $this->redirectToRoute('admin_plat_edit', ['id' => $id]);
        }

        // Récupère le Plat par son ID
        $plat = $platRepository->findById($id);

        $tab_plat_type = $platTypeRepository->findAll();
        $tab_plat_allergene = $platAllergeneRepository->findAllIdByPlatId($id);
        $tab_allergenes = $generiqueRepository->findAll('allergene');

        // Affiche le plat
        return $this->render('admin/plat/edit.html.twig', [
            'id' => $id,
            'plat' => $plat,
            'tab_plat_type' => $tab_plat_type,
            'tab_plat_allergene' => $tab_plat_allergene,
            'tab_allergenes' => $tab_allergenes,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete')]
    public function delete(int $id, PlatRepository $platRepository, Request $request): Response
    {
        $comeFrom = $request->query->get('comeFrom');

        $plat = $platRepository->findById($id);

        $ret = $platRepository->delete($id);

        if ($ret)
        {
            // Supprimer l'image
            if (file_exists($plat->getImage())) {
                unlink($plat->getImage());
            }

            $this->addFlash('success', 'Plat supprimé avec succès');
        }
        else
        {
            $this->addFlash('danger', "Une erreur est survenue lors de la suppression du plat : " . $ret);
        }

        return $this->redirectToRoute('admin_plat_index', ['comeFrom' => $comeFrom]);
    }

    private function valideImage(UploadedFile $image): string
    {
        $retour = "";

        $tailleMax = 5 * 1024 * 1024;
        $extensionsValides = ['image/jpeg', 'image/png', 'image/webp'];

        // Provenance du fichier
        if (!$image instanceof UploadedFile) {
            $retour = "Fichier inconnu";
        }
        // Téléchargement réussi
        elseif (!$image->isValid()) {
            $retour .= 'Erreur de téléchargement du fichier : '.$image->getClientOriginalName();
        }
        // Taille Max
        elseif ($image->getSize() > $tailleMax) {
            $retour .= $image->getClientOriginalName()." dépasse la taille maximale autorisée (5 Mo) \n";
        }
        // Extensions autorisées
        elseif (!in_array($image->getMimeType(), $extensionsValides, true)) {
            $retour .= $image->getClientOriginalName()." : type de fichier non autorisé \n";
        }

        return $retour;
    }
}

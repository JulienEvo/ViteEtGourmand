<?php
/**
 * Controller pour les tables avec comme seuls champs : "id" et "libelle" et "description"
 */

namespace App\Controller;

use App\Entity\Allergene;
use App\Entity\CommandeEtat;
use App\Entity\PlatType;
use App\Entity\Regime;
use App\Repository\BaseRepository;
use App\Repository\GeneriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/gen/{type}', name: 'admin_ref_')]
final class GeneriqueController extends AbstractController
{
    #[Route('/', name: 'list')]
    public function list(string $type, GeneriqueRepository $generiqueRepository): Response
    {
        $generiqueRepository->type = $type;

        $items = $generiqueRepository->findAll();

        return $this->render('admin/ref/list.html.twig', [
            'items' => $items,
            'type' => $type,
        ]);
    }
}

<?php

namespace App\Service;

use App\Entity\Societe;
use App\Repository\AvisRepository;
use App\Repository\HoraireRepository;
use App\Repository\SocieteRepository;

class QueryService
{
    public function __construct(
        private SocieteRepository $societeRepository,
        private HoraireRepository $horaireRepository,
        private AvisRepository $avisRepository,
    ) {}

    public function getSociete(int $societe_id = 1): Societe
    {
        return $this->societeRepository->findById($societe_id);
    }

    public function getHoraire(int $societe_id = 1): array
    {
        return $this->horaireRepository->findBySociete($societe_id);
    }

    public function getLastAvis(int $limit = 10): array
    {
        return $this->avisRepository->getLastAvis($limit);
    }

}

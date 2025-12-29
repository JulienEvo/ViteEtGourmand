<?php

namespace App\twig;

use App\Service\FonctionsService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class FonctionsExtension extends AbstractExtension
{
    public function __construct(
        private FonctionsService $fonctionsService
    ) {}

    public function getFilters(): array
    {
        return [
            new TwigFilter('formatTelFr', [$this, 'formatTelFr']),
        ];
    }

    public function formatTelFr(?string $phone): ?string
    {
        return $this->fonctionsService->formatTelFr($phone);
    }
}

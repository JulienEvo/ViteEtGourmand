<?php

namespace App\Twig;

use App\Service\QueryService;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class QueryExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(private QueryService $queryService) {}

    public function getGlobals(): array
    {
        return [
            'query_service' => $this->queryService,
        ];
    }
}

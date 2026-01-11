<?php

namespace App\EventSubscriber;

use App\Service\QueryService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class GlobalTemplateSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Environment $twig,
        private QueryService $queryService
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onController',
        ];
    }

    public function onController(ControllerEvent $event): void
    {
        $this->twig->addGlobal('societe', $this->queryService->getSociete(1));
        $this->twig->addGlobal('horaires', $this->queryService->getHoraire(1));
        $this->twig->addGlobal('lastAvis', $this->queryService->getLastAvis(5));
    }
}

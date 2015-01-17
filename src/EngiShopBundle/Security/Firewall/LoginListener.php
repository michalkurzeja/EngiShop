<?php

namespace EngiShopBundle\Security\Firewall;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        if ($event->getRequest()->get('_route') != 'engishop_front_login_check') return;

        $event->getAuthenticationToken()->getUser()->setLastLogin(new \DateTime());
        $this->entityManager->flush();
    }
}
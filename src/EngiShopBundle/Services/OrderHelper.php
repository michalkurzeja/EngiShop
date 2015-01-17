<?php

namespace EngiShopBundle\Services;

use Doctrine\ORM\EntityManager;

class OrderHelper
{
    /** @var EntityManager */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return int
     */
    public function getAwaitingOrders()
    {
        return $this->entityManager->getRepository('EngiShopBundle:OrderClass')->getAwaitingOrdersCount();
    }
}
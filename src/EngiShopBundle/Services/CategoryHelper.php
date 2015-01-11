<?php

namespace EngiShopBundle\Services;

use Doctrine\ORM\EntityManager;

class CategoryHelper
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getActiveCategories()
    {
        return $this->entityManager->getRepository('EngiShopBundle:Category')->getActiveCategories();
    }
}
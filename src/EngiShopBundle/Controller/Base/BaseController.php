<?php

namespace EngiShopBundle\Controller\Base;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
    /**
     * @return EntityManager
     */
    protected function getEm()
    {
        return $this->getDoctrine()->getManager();
    }
}
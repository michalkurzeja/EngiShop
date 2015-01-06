<?php

namespace EngiShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('EngiShopBundle:Default:index.html.twig', array('name' => $name));
    }
}

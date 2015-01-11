<?php

namespace EngiShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class AdminUserController extends Base\AdminController
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'users' => $this->getRepository('EngiShopBundle:User')->findAll()
        ];
    }
}
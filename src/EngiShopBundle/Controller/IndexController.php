<?php

namespace EngiShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class IndexController extends Base\FrontController
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'posts' => $this->getEm()->getRepository('EngiShopBundle:Post')->getFeaturedPosts(),
            'products' => $this->getEm()->getRepository('EngiShopBundle:Product')->getFeaturedProducts()
        ];
    }
}

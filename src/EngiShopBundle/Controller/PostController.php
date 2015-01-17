<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class PostController extends Base\FrontController
{
    /**
     * @return array
     *
     * @Template
     */
    public function indexAction()
    {
        return [
            'posts' => $this->getEm()->getRepository('EngiShopBundle:Post')->findBy([], ['createdAt' => 'desc'])
        ];
    }

    /**
     * @param Post $post
     * @return array
     *
     * @Template
     */
    public function showAction(Post $post)
    {
        return [
            'post' => $post
        ];
    }
}
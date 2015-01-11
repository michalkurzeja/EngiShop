<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategoryController extends Base\FrontController
{
    /**
     * @Template
     * @return array
     */
    public function indexAction()
    {
        return [
            'categories' => $this->getEm()->getRepository('EngiShopBundle:Category')->getActiveCategories()
        ];
    }

    /**
     * @Template
     * @param Category $category
     * @return array
     */
    public function showAction(Category $category)
    {
        return [
            'category' => $category
        ];
    }
}
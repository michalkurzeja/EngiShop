<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProductController extends Base\FrontController
{
    /**
     * @Template
     * @param Product $product
     * @return array
     */
    public function showAction(Product $product)
    {
        return [
            'product' => $product
        ];
    }
}
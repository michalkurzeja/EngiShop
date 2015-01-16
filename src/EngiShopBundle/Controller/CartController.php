<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class CartController extends Base\FrontController
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'cart' => $this->getUser()->getCart()
        ];
    }

    /**
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function addAction(Product $product)
    {
        $cart = $this->get('engishop.cart_helper')->addToCart($product);

        $this->getEm()->persist($cart);
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_front_cart');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function setQuantityAction(Request $request)
    {
        $quantities = $request->request->get('quantity');

        $this->get('engishop.cart_helper')->setItemsQuantity($quantities);

        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_front_cart');
    }
}
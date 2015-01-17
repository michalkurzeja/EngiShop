<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\OrderClass;
use EngiShopBundle\Form\Type\OrderType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Base\FrontController
{
    /**
     * @Template
     * @param Request $request
     * @return array
     */
    public function newAction(Request $request)
    {
        $cartHelper = $this->get('engishop.cart_helper');
        $discount = $cartHelper->getDiscount($request->request->get('discountCode'));

        $form = $this->createForm(new OrderType(), new OrderClass($this->getUser()));

        if ($form->handleRequest($request)->isValid()) {
            $this->getEm()->persist($form->getData()->setDiscount($discount));
            $cartHelper->getCart()->clearItems();
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_front_homepage');
        }

        return [
            'order' => $form->getData(),
            'discount' => $discount,
            'form' => $form->createView()
        ];
    }
}
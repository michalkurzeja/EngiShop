<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\DiscountCode;
use EngiShopBundle\Form\Type\DiscountCodeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AdminDiscountCodeController extends Base\AdminController
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'codes' => $this->getEm()->getRepository('EngiShopBundle:DiscountCode')->findAll()
        ];
    }

    /**
     * @Template
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(new DiscountCodeType());

        if ($form->handleRequest($request)->isValid()) {
            $this->getEm()->persist($form->getData());
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_discount_code');
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Template
     * @param DiscountCode $code
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(DiscountCode $code, Request $request)
    {
        $form = $this->createForm(new DiscountCodeType(), $code);

        if ($form->handleRequest($request)->isValid()) {
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_discount_code');
        }

        return [
            'code' => $code,
            'form' => $form->createView()
        ];
    }

    public function toggleAction(DiscountCode $code)
    {
        $code->setActive(!$code->isActive());
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_discount_code');
    }

    public function deleteAction(DiscountCode $code)
    {
        $this->getEm()->remove($code);
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_discount_code');
    }
}
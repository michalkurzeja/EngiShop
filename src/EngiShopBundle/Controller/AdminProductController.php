<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Form\Type\ProductType;
use EngiShopBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminProductController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'products' => $this->getDoctrine()->getRepository('EngiShopBundle:Product')->findAll()
        ];
    }

    /**
     * @Template
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($product);
            $em->flush();

            return $this->redirect($this->generateUrl('engishop_admin_product'));
        }

        return [
            'form' => $form->createView(),
            'product' => $product
        ];
    }

    /**
     * @Template
     * @param Product $product
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Product $product)
    {
        $request = $this->get('request');
        $form = $this->createForm(new ProductType(), $product);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            return $this->redirect($this->generateUrl('engishop_admin_product'));
        }

        return [
            'product' => $product,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleAction(Product $product)
    {
        $product->setActive(!$product->getActive());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('engishop_admin_product'));
    }

    /**
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Product $product)
    {
        $this->getDoctrine()->getManager()->remove($product);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('engishop_admin_product'));
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function deleteImageAction(Product $product)
    {
        $product->removeImage();
        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse(true);
    }
} 
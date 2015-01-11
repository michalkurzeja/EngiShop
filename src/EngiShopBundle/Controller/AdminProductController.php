<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Form\Type\ProductType;
use EngiShopBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AdminProductController extends Base\AdminController
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'products' => $this->getRepository('EngiShopBundle:Product')->findAll()
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
            $this->getEm()->persist($product);
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_product');
        }

        return [
            'product' => $product,
            'form' => $form->createView()
        ];
    }

    /**
     * @Template
     * @param Product $product
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Product $product, Request $request)
    {
        $form = $this->createForm(new ProductType(), $product);

        if ($form->handleRequest($request)->isValid()) {
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_product');
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
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_product');
    }

    /**
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Product $product)
    {
        $this->getEm()->remove($product);
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_product');
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function deleteImageAction(Product $product)
    {
        $product->removeImage();
        $this->getEm()->flush();

        return new JsonResponse(true);
    }
} 
<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Form\Type\CategoryType;
use EngiShopBundle\Entity\Category;
use EngiShopBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminCategoryController extends Controller
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'categories' => $this->getDoctrine()->getManager()->getRepository('JKPCoreBundle:Category')->findAll()
        ];
    }

    /**
     * @Template
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(new CategoryType(), $category);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirect($this->generateUrl('engishop_admin_category'));
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Template
     * @param Category $category
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Category $category)
    {
        $request = $this->get('request');
        $form = $this->createForm(new CategoryType(), $category);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect($this->generateUrl('engishop_admin_category'));
        }

        return [
            'category' => $category,
            'form' => $form->createView()
        ];
    }

    /**
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleAction(Category $category)
    {
        $category->setActive(!$category->isActive());
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('engishop_admin_category'));
    }

    /**
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Category $category)
    {
        /** @var Product $product */
        foreach ($category->getProducts() as $product) {
            $product->setCategory(null);
        }

        $this->getDoctrine()->getManager()->remove($category);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirect($this->generateUrl('engishop_admin_category'));
    }
} 
<?php

namespace EngiShopBundle\Controller;

use Doctrine\ORM\EntityManager;
use EngiShopBundle\Form\Type\CategoryType;
use EngiShopBundle\Entity\Category;
use EngiShopBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AdminCategoryController extends Base\AdminController
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'categories' => $this->getRepository('EngiShopBundle:Category')->findAll()
        ];
    }

    /**
     * @Template
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(new CategoryType());

        if ($form->handleRequest($request)->isValid()) {
            $this->getEm()->persist($form->getData());
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_category');
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Template
     * @param Category $category
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Category $category, Request $request)
    {
        $form = $this->createForm(new CategoryType(), $category);

        if ($form->handleRequest($request)->isValid()) {
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_category');
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
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_category');
    }

    /**
     * @param Category $category
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Category $category)
    {
        /** @var Product $product */
        foreach ($category->getProducts() as $product) $product->setCategory(null);

        $this->getEm()->remove($category);
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_category');
    }
} 
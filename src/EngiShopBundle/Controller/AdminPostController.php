<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\Post;
use EngiShopBundle\Form\Type\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AdminPostController extends Base\AdminController
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'posts' => $this->getEm()->getRepository('EngiShopBundle:Post')->findBy([], ['createdAt' => 'desc'])
        ];
    }

    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Template
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(new PostType());

        if ($form->handleRequest($request)->isValid()) {
            $this->getEm()->persist($form->getData());
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_post');
        }

        return [
            'form' => $form->createView()
        ];
    }


    /**
     * @param Post $post
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Template
     */
    public function editAction(Post $post, Request $request)
    {
        $form = $this->createForm(new PostType(), $post);

        if ($form->handleRequest($request)->isValid()) {
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_post');
        }

        return [
            'post' => $post,
            'form' => $form->createView()
        ];
    }

    public function deleteAction(Post $post)
    {
        $this->getEm()->remove($post);
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_post');
    }
}
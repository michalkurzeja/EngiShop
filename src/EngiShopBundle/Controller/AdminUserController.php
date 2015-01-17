<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\User;
use EngiShopBundle\Form\Type\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class AdminUserController extends Base\AdminController
{
    /**
     * @Template
     */
    public function indexAction()
    {
        return [
            'users' => $this->getEm()->getRepository('EngiShopBundle:User')->findAll()
        ];
    }

    /**
     * @Template
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request)
    {
        $form = $this->createForm(new UserType());

        if ($form->handleRequest($request)->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $plainPassword = $form['newPassword']->getData();
            $user->setPassword($this->get('engishop.password_encoder')->encodePassword($user, $plainPassword));

            $this->getEm()->persist($user);
            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_user');
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Template
     * @param User $user
     * @param Request $request
     * @return array
     */
    public function editAction(User $user, Request $request)
    {
        $form = $this->createForm(new UserType(), $user, ['edit' => true]);

        if ($form->handleRequest($request)->isValid()) {
            $plainPassword = $form['newPassword']->getData();

            if (!empty($plainPassword))  {
                $user->setPassword($this->get('engishop.password_encoder')->encodePassword($user, $plainPassword));
            }

            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_admin_user');
        }

        return [
            'user' => $user,
            'form' => $form->createView()
        ];
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(User $user)
    {
        $this->getEm()->remove($user);
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_user');
    }

    /**
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function toggleAction(User $user)
    {
        $user->setIsActive(!$user->getIsActive());
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_user');
    }
}
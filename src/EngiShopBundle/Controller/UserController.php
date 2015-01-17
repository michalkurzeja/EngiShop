<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\User;
use EngiShopBundle\Form\Type\RegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Base\FrontController
{
    /**
     * @param Request $request
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Template
     */
    public function registerAction(Request $request)
    {
        $form = $this->createForm(new RegisterType());

        if ($form->handleRequest($request)->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            $plainPassword = $form['newPassword']->getData();
            $user->setPassword($this->get('engishop.password_encoder')->encodePassword($user, $plainPassword));

            $this->getEm()->persist($user);
            $this->getEm()->flush();

            return $this->render('@EngiShop/User/registerAfter.html.twig');
        }

        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Template
     */
    public function showAction()
    {
        return [
            'user' => $this->getUser()
        ];
    }

    /**
     * @Template
     */
    public function editAction(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();

        $form = $this->createForm(new RegisterType(), $user, ['edit' => true]);

        if ($form->handleRequest($request)->isValid()) {
            $plainPassword = $form['newPassword']->getData();

            if (!empty($plainPassword))  {
                $user->setPassword($this->get('engishop.password_encoder')->encodePassword($user, $plainPassword));
            }

            $this->getEm()->flush();

            return $this->redirectToRoute('engishop_front_user_show', ['id' => $user->getId()]);
        }

        return [
            'form' => $form->createView()
        ];
    }
}
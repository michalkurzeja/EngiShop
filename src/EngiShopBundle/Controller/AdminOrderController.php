<?php

namespace EngiShopBundle\Controller;

use EngiShopBundle\Entity\OrderClass;
use EngiShopBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class AdminOrderController extends Base\AdminController
{
    /**
     * @param User $user
     * @return array
     *
     * @Template
     */
    public function indexAction(User $user = null)
    {
        $findBy = [];

        if ($user) $findBy['user'] = $user;

        return [
            'orders' => $this->getEm()->getRepository('EngiShopBundle:OrderClass')->findBy($findBy, ['completed' => 'asc', 'inProcess' => 'asc', 'createdAt' => 'desc']),
            'user' => $user
        ];
    }

    /**
     * @param OrderClass $order
     * @param User $user
     * @return array
     *
     * @Template
     */
    public function showAction(OrderClass $order, User $user = null)
    {
        return [
            'order' => $order,
            'user' => $user
        ];
    }

    /**
     * @param OrderClass $order
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @ParamConverter("user", class="EngiShopBundle:User", isOptional="true", options={"mapping": {"user": "id"}})
     */
    public function acceptAction(OrderClass $order, User $user = null)
    {
        if ($order->isInProcess() || $order->isCompleted()) {
            throw new AccessDeniedException;
        }

        $order->setInProcess(true);
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_order', ['user' => $user ? $user->getId() : null]);
    }

    /**
     * @param OrderClass $order
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @ParamConverter("user", class="EngiShopBundle:User", isOptional="true", options={"mapping": {"user": "id"}})
     */
    public function completeAction(OrderClass $order, User $user = null)
    {
        if (!$order->isInProcess() || $order->isCompleted()) {
            throw new AccessDeniedException;
        }

        $order->setCompleted(true)->setInProcess(false);
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_order', ['user' => $user ? $user->getId() : null]);
    }

    /**
     * @param OrderClass $order
     * @param User $user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @ParamConverter("user", class="EngiShopBundle:User", isOptional="true", options={"mapping": {"user": "id"}})
     */
    public function deleteAction(OrderClass $order, User $user = null)
    {
        if ($order->isInProcess()) {
            throw new AccessDeniedException;
        }

        $this->getEm()->remove($order);
        $this->getEm()->flush();

        return $this->redirectToRoute('engishop_admin_order', ['user' => $user ? $user->getId() : null]);
    }
}
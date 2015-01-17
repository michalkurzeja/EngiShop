<?php

namespace EngiShopBundle\Services;

use Doctrine\ORM\EntityManager;
use EngiShopBundle\Entity\Cart;
use EngiShopBundle\Entity\CartItem;
use EngiShopBundle\Entity\Product;
use EngiShopBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class CartHelper
{
    /** @var AuthorizationCheckerInterface */
    private $authChecker;
    /** @var TokenStorageInterface */
    private $tokenStorage;
    /** @var EntityManager */
    private $entityManager;

    public function __construct(AuthorizationCheckerInterface $authChecker, TokenStorageInterface $tokenStorage, EntityManager $entityManager)
    {
        $this->authChecker = $authChecker;
        $this->tokenStorage = $tokenStorage;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Product $product
     * @param int $quantity
     * @return Cart
     */
    public function addToCart(Product $product, $quantity = 1)
    {
        $cart = $this->getCart();

        /** @var CartItem $item */
        if ($item = $cart->findProduct($product)) {
            $item->addQuantity($quantity);
            return $cart;
        }

        $cart->addItem(new CartItem($product, $quantity));
        return $cart;
    }

    public function setItemsQuantity($quantities)
    {
        $cart = $this->getCart();

        foreach ($quantities as $id => $quantity) {
            $item = $cart->findItem($id);

            if (!$item) continue;

            $quantity > 0
                ? $item->setQuantity($quantity)
                : $cart->removeItem($item);
        }
    }

    /**
     * @return int
     */
    public function getItemCount()
    {
        return $this->getCart()->getItemsQuantity();
    }

    /**
     * @param $code
     * @return float
     */
    public function getDiscount($code)
    {
        if (!$code) return 0;

        $discountCode = $this->entityManager->getRepository('EngiShopBundle:DiscountCode')->findOneBy(['code' => $code]);

        if (!$discountCode) return 0;

        return $discountCode->getDiscount();
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
       if (!$this->authChecker->isGranted('ROLE_USER')) {
           throw new AccessDeniedException;
       }

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();
        $cart = $user->getCart();

        if (!$cart) {
            $cart = new Cart($user);
        }

        return $cart;
    }
}
<?php

namespace EngiShopBundle\Services;

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

    public function __construct(AuthorizationCheckerInterface $authChecker, TokenStorageInterface $tokenStorage)
    {
        $this->authChecker = $authChecker;
        $this->tokenStorage = $tokenStorage;
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

    public function getItemCount()
    {
        return $this->getCart()->getItemsQuantity();
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
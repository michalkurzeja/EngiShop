<?php

namespace EngiShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CartItem
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EngiShopBundle\Entity\CartItemRepository")
 */
class CartItem
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $product;

    /**
     * @var Cart
     *
     * @ORM\ManyToOne(targetEntity="Cart", inversedBy="items")
     */
    private $cart;

    public function __construct(Product $product, $quantity = 1)
    {
        $this->setProduct($product)->setQuantity($quantity);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return CartItem
     */
    public function setQuantity($quantity)
    {
        if ($quantity < 0) $quantity = 0;

        $this->quantity = $quantity;
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param integer $quantity
     * @return $this
     */
    public function addQuantity($quantity)
    {
        $this->quantity += $quantity;
        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return Cart
     */
    public function getCart()
    {
        return $this->cart;
    }

    /**
     * @param Cart $cart
     * @return $this
     */
    public function setCart(Cart $cart)
    {
        $this->cart = $cart;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getProduct()->getName();
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->getProduct()->getPrice();
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        return $this->getProduct()->getPrice() * $this->getQuantity();
    }
}

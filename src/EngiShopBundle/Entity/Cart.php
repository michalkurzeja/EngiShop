<?php

namespace EngiShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Mapping as ORM;

/**
 * Cart
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EngiShopBundle\Entity\CartRepository")
 */
class Cart
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
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CartItem", mappedBy="cart", fetch="EXTRA_LAZY", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $items;

    /**
     * @var User
     *
     * @ORM\OneToOne(targetEntity="User", inversedBy="cart")
     */
    private $user;

    public function __construct(User $user)
    {
        $this
            ->setUser($user)
            ->setItems(new ArrayCollection());
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
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param CartItem $item
     * @return $this
     */
    public function addItem(CartItem $item)
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setCart($this);
        }

        return $this;
    }

    /**
     * @param CartItem $item
     * @return $this
     */
    public function removeItem(CartItem $item)
    {
        $this->items->removeElement($item);
        return $this;
    }

    /**
     * @param ArrayCollection $items
     * @return $this
     */
    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param Product $product
     * @return CartItem|null
     */
    public function findProduct(Product $product)
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('product', $product))->setMaxResults(1);

        return $this->items->matching($criteria)->first();
    }

    /**
     * @param integer $id
     * @return CartItem|null
     */
    public function findItem($id)
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('id', $id));

        return $this->items->matching($criteria)->first();
    }

    public function getItemsQuantity()
    {
        $count = 0;

        /** @var CartItem $item */
        foreach ($this->getItems() as $item) $count += $item->getQuantity();

        return $count;
    }

    public function getTotal()
    {
        $total = 0;

        /** @var CartItem $item */
        foreach ($this->getItems() as $item) $total += $item->getTotal();

        return $total;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        $user->setCart($this);
        return $this;
    }
}

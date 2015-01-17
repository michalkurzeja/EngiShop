<?php

namespace EngiShopBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrderClass
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EngiShopBundle\Entity\OrderClassRepository")
 */
class OrderClass
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
     * @ORM\Column(type="string")
     */
    private $firstName;

    /**
     * @ORM\Column(type="string")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @ORM\Column(type="string")
     */
    private $address2;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $zip;

    /**
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     */
    private $state;

    /**
     * @ORM\Column(type="string", length=2)
     */
    private $country;

    /**
     * @var boolean
     *
     * @ORM\Column(name="inProcess", type="boolean")
     */
    private $inProcess;

    /**
     * @var boolean
     *
     * @ORM\Column(name="completed", type="boolean")
     */
    private $completed;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(type="float")
     */
    private $discount;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="OrderItem", mappedBy="order", fetch="EXTRA_LAZY", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $items;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders")
     */
    private $user;

    public function __construct(User $user)
    {
        $this
            ->setCreatedAt(new \DateTime())
            ->setInProcess(false)
            ->setCompleted(false)
            ->setDiscount(0)
            ->setUser($user)
            ->setItems(new ArrayCollection());

        /** @var CartItem $item */
        foreach ($user->getCart()->getItems() as $item) {
            $this->addItem(new OrderItem($item));
        }
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
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     * @return OrderClass
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     * @return OrderClass
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return OrderClass
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     * @return OrderClass
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     * @return OrderClass
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     * @return OrderClass
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     * @return OrderClass
     */
    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     * @return OrderClass
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Set inProcess
     *
     * @param boolean $inProcess
     * @return OrderClass
     */
    public function setInProcess($inProcess)
    {
        $this->inProcess = $inProcess;

        return $this;
    }

    /**
     * Get inProcess
     *
     * @return boolean 
     */
    public function isInProcess()
    {
        return $this->inProcess;
    }

    /**
     * Set completed
     *
     * @param boolean $completed
     * @return OrderClass
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * Get completed
     *
     * @return boolean 
     */
    public function isCompleted()
    {
        return $this->completed;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return OrderClass
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param string $discount
     * @return OrderClass
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param OrderItem $item
     * @return $this
     */
    public function addItem(OrderItem $item)
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setOrder($this);
        }

        return $this;
    }

    /**
     * @param OrderItem $item
     * @return $this
     */
    public function removeItem(OrderItem $item)
    {
        $this->items->removeElement($item);
        return $this;
    }

    /**
     * @param ArrayCollection $items
     * @return OrderClass
     */
    public function setItems(ArrayCollection $items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @return int
     */
    public function getItemsQuantity()
    {
        $count = 0;

        /** @var CartItem $item */
        foreach ($this->getItems() as $item) $count += $item->getQuantity();

        return $count;
    }

    /**
     * @return float
     */
    public function getTotal()
    {
        $total = 0;

        /** @var CartItem $item */
        foreach ($this->getItems() as $item) $total += $item->getTotal();

        return $total;
    }

    public function getTotalWithDiscount()
    {
        return $this->getTotal() * (1 - $this->getDiscount());
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
     * @return OrderClass
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        $this
            ->setFirstName($user->getFirstName())
            ->setLastName($user->getLastName())
            ->setAddress($user->getAddress())
            ->setAddress2($user->getAddress2())
            ->setZip($user->getZip())
            ->setCity($user->getCity())
            ->setState($user->getState())
            ->setCountry($user->getCountry());

        $user->addOrder($this);

        return $this;
    }


}

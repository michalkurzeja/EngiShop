<?php

namespace EngiShopBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * Product
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="EngiShopBundle\Entity\ProductRepository")
 */
class Product
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var boolean
     *
     * @ORM\Column(name="featured", type="boolean")
     */
    private $featured;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var File
     *
     * @ORM\OneToOne(targetEntity="File", cascade={"persist", "remove"}, orphanRemoval=true, fetch="EAGER")
     */
    private $image;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products", fetch="EAGER")
     */
    private $category;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
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
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Product
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param float $price
     * @return $this
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param boolean $active
     * @return $this
     */
    public function setActive($active)
    {
        $this->active = $active;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @param boolean $featured
     * @return $this
     */
    public function setFeatured($featured)
    {
        $this->featured = $featured;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getFeatured()
    {
        return $this->featured;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Product
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
     * @param \EngiShopBundle\Entity\File $image
     * @return $this
     */
    public function setImage(File $image)
    {
        $this->image = $image;
        return $this;
    }

    /**
     * @return \EngiShopBundle\Entity\File
     */
    public function getImage()
    {
        return $this->image;
    }

    public function getImagePath()
    {
        return $this->image
            ? $this->image->getWebPath()
            : 'resources/img/no-image.jpg';
    }

    public function removeImage()
    {
        $this->image = null;
        return $this;
    }

    /**
     * @param \EngiShopBundle\Entity\Category $category
     * @return $this
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return \EngiShopBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata) {
        $metadata->addPropertyConstraint('slug', new NotNull(array('message' => 'Ta wartość nie powinna być pusta.')));
        $metadata->addPropertyConstraint('slug', new Regex(array(
            'message' => 'Ta wartość nie jest poprawnym adresem.',
            'pattern' => '/^[a-zA-Z0-9_\-\+]+$/'
        )));
    }

    public function __toString()
    {
        return $this->getName() ?: '';
    }
}

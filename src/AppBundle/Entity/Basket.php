<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Basket
 *
 * @ORM\Table(name="basket")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BasketRepository")
 */
class Basket
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(name="articles", type="array")
     */
    private $articles;

    /**
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="delivry", type="datetime")
     */
    private $delivry;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set articles
     *
     * @param array $articles
     *
     * @return Basket
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;

        return $this;
    }

    /**
     * Get articles
     *
     * @return array
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return Basket
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set delivry
     *
     * @param \DateTime $delivry
     *
     * @return Basket
     */
    public function setDelivry($delivry)
    {
        $this->delivry = $delivry;

        return $this;
    }

    /**
     * Get delivry
     *
     * @return \DateTime
     */
    public function getDelivry()
    {
        return $this->delivry;
    }
}


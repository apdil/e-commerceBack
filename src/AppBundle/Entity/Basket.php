<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


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
     * @var int
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="delivry", type="string", length=255)
     */
    private $delivry = "";

    /**
    * @ORM\ManyToMany(targetEntity="Article", mappedBy="basket")
    */
    private $articles;

    /**
     * @ORM\OneToOne(targetEntity="Client", mappedBy="basket_parent")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client_parent;
    
    public function __construct() {
        $this->articles = new ArrayCollection();
        $this->basket = new ArrayCollection();
    }


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
     * @param string $delivry
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
     * @return string
     */
    public function getDelivry()
    {
        return $this->delivry;
    }

    /**
     * Add article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Basket
     */
    public function addArticle(\AppBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \AppBundle\Entity\Article $article
     */
    public function removeArticle(\AppBundle\Entity\Article $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }



    /**
     * Set clientParent
     *
     * @param \AppBundle\Entity\Client $clientParent
     *
     * @return Basket
     */
    public function setClientParent(\AppBundle\Entity\Client $clientParent = null)
    {
        $this->client_parent = $clientParent;

        return $this;
    }

    /**
     * Get clientParent
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClientParent()
    {
        return $this->client_parent;
    }
}

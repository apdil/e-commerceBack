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
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="delivry", type="string", length=255)
     */
    private $delivry;

    /**
    * @ORM\ManyToMany(targetEntity="Article", mappedBy="basket")
    */
    private $articles;

    /**
    * @ORM\OneToMany(targetEntity="Client", mappedBy="basket")
    */
    private $basket;

    /**
     * @ORM\OneToOne(targetEntity="Client")
     * @ORM\JoinColumn(name="client_id", referencedColumnName="id")
     */
    private $client_parent;

    /**
     * @ORM\OneToOne(targetEntity="Commande")
     * @ORM\JoinColumn(name="commande_id", referencedColumnName="id")
     */
    private $commande_parent; 
    
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
     * Add basket
     *
     * @param \AppBundle\Entity\Client $basket
     *
     * @return Basket
     */
    public function addBasket(\AppBundle\Entity\Client $basket)
    {
        $this->basket[] = $basket;

        return $this;
    }

    /**
     * Remove basket
     *
     * @param \AppBundle\Entity\Client $basket
     */
    public function removeBasket(\AppBundle\Entity\Client $basket)
    {
        $this->basket->removeElement($basket);
    }

    /**
     * Get basket
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBasket()
    {
        return $this->basket;
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

    /**
     * Set commandeParent
     *
     * @param \AppBundle\Entity\Commande $commandeParent
     *
     * @return Basket
     */
    public function setCommandeParent(\AppBundle\Entity\Commande $commandeParent = null)
    {
        $this->commande_parent = $commandeParent;

        return $this;
    }

    /**
     * Get commandeParent
     *
     * @return \AppBundle\Entity\Commande
     */
    public function getCommandeParent()
    {
        return $this->commande_parent;
    }
}

<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandeRepository")
 */
class Commande
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
    * @ORM\ManyToMany(targetEntity="Preparateur", inversedBy="commandes", cascade={"persist"})
    * @ORM\JoinTable(name="commande_preparateur")
    */
    private $preparateur;

    /**
    * @ORM\ManyToMany(targetEntity="Client", inversedBy="commandes", cascade={"persist"})
    * @ORM\JoinTable(name="commande_client")
    */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="Basket")
     * @ORM\JoinColumn(name="basket_id", referencedColumnName="id")
     */
    private $basket_parent; 

    public function __construct(){
        $this->preparateur = new ArrayCollection();
        $this->client = new ArrayCollection();
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
     * Add preparateur
     *
     * @param \AppBundle\Entity\Preparateur $preparateur
     *
     * @return Commande
     */
    public function addPreparateur(\AppBundle\Entity\Preparateur $preparateur)
    {
        $this->preparateur[] = $preparateur;

        return $this;
    }

    /**
     * Remove preparateur
     *
     * @param \AppBundle\Entity\Preparateur $preparateur
     */
    public function removePreparateur(\AppBundle\Entity\Preparateur $preparateur)
    {
        $this->preparateur->removeElement($preparateur);
    }

    /**
     * Get preparateur
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPreparateur()
    {
        return $this->preparateur;
    }

    /**
     * Add client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Commande
     */
    public function addClient(\AppBundle\Entity\Client $client)
    {
        $this->client[] = $client;

        return $this;
    }

    /**
     * Remove client
     *
     * @param \AppBundle\Entity\Client $client
     */
    public function removeClient(\AppBundle\Entity\Client $client)
    {
        $this->client->removeElement($client);
    }

    /**
     * Get client
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set basketParent
     *
     * @param \AppBundle\Entity\Basket $basketParent
     *
     * @return Commande
     */
    public function setBasketParent(\AppBundle\Entity\Basket $basketParent = null)
    {
        $this->basket_parent = $basketParent;

        return $this;
    }

    /**
     * Get basketParent
     *
     * @return \AppBundle\Entity\Basket
     */
    public function getBasketParent()
    {
        return $this->basket_parent;
    }
}

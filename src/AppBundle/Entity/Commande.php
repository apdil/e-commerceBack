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
     * @var bool
     *
     * @ORM\Column(name="treatment", type="boolean")
     */
    private $treatment = false;

    /**
     * @var bool
     *
     * @ORM\Column(name="delivring", type="boolean")
     */
    private $inDelivring = false;

    /**
    * @ORM\ManyToMany(targetEntity="Preparateur", inversedBy="commandes", cascade={"persist"})
    * @ORM\JoinTable(name="commande_preparateur")
    */
    private $preparateur;

    /**
    * @ORM\ManyToOne(targetEntity="Client", inversedBy="commandes", cascade={"persist"})
    * @ORM\joinColumn(name="clientCommande_id", referencedColumnName="id")
    */
    private $client;

    /**
    * @ORM\ManyToMany(targetEntity="Article", inversedBy="commandes", cascade={"persist"})
    * @ORM\JoinTable(name="commandes_articles")
    */
    private $articles;

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
     * Add article
     *
     * @param \AppBundle\Entity\Article $article
     *
     * @return Commande
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
     * Set client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Commande
     */
    public function setClient(\AppBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set treatment
     *
     * @param boolean $treatment
     *
     * @return Commande
     */
    public function setTreatment($treatment)
    {
        $this->treatment = $treatment;

        return $this;
    }

    /**
     * Get treatment
     *
     * @return boolean
     */
    public function getTreatment()
    {
        return $this->treatment;
    }

    /**
     * Set inDelivring
     *
     * @param boolean $inDelivring
     *
     * @return Commande
     */
    public function setInDelivring($inDelivring)
    {
        $this->inDelivring = $inDelivring;

        return $this;
    }

    /**
     * Get inDelivring
     *
     * @return boolean
     */
    public function getInDelivring()
    {
        return $this->inDelivring;
    }
}

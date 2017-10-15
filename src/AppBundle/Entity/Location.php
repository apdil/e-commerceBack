<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Location
 *
 * @ORM\Table(name="location")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LocationRepository")
 */
class Location
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
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;

    /**
     * @var int
     *
     * @ORM\Column(name="codePostale", type="integer")
     */
    private $codePostale;

    /**
     * @var int
     *
     * @ORM\Column(name="tel", type="integer")
     */
    private $tel;

    /**
    * @ORM\OneToMany(targetEntity="Client", mappedBy="location")
    */
    private $clients;

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
     * Set adress
     *
     * @param string $adress
     *
     * @return Location
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Location
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set codePostale
     *
     * @param integer $codePostale
     *
     * @return Location
     */
    public function setCodePostale($codePostale)
    {
        $this->codePostale = $codePostale;

        return $this;
    }

    /**
     * Get codePostale
     *
     * @return int
     */
    public function getCodePostale()
    {
        return $this->codePostale;
    }

    /**
     * Set tel
     *
     * @param integer $tel
     *
     * @return Location
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return int
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set clients
     *
     * @param \AppBundle\Entity\Client $clients
     *
     * @return Location
     */
    public function setClients(\AppBundle\Entity\Client $clients = null)
    {
        $this->clients = $clients;

        return $this;
    }

    /**
     * Get clients
     *
     * @return \AppBundle\Entity\Client
     */
    public function getClients()
    {
        return $this->clients;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clients = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add client
     *
     * @param \AppBundle\Entity\Client $client
     *
     * @return Location
     */
    public function addClient(\AppBundle\Entity\Client $client)
    {
        $this->clients[] = $client;

        return $this;
    }

    /**
     * Remove client
     *
     * @param \AppBundle\Entity\Client $client
     */
    public function removeClient(\AppBundle\Entity\Client $client)
    {
        $this->clients->removeElement($client);
    }
}

<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Countries
 *
 * @ORM\Table(name="Countries")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\CountriesRepository")
 */
class Countries
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
     * @ORM\Column(name="CountryName", type="string", length=255)
     */
    private $countryName;

    /**
     * @ORM\OneToMany(targetEntity="TIC\PlatformBundle\Entity\Trainers", mappedBy="Country")
     */
    private $trainers;

    /**
     * @ORM\OneToMany(targetEntity="Addresses", mappedBy="countries")
     */
    private $addresses;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->trainers) == 0 && count($this->addresses) == 0;
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
     * Set countryName
     *
     * @param string $countryName
     * @return Countries
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Get countryName
     *
     * @return string 
     */
    public function getCountryName()
    {
        return $this->countryName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trainers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add trainers
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainers
     * @return Countries
     */
    public function addTrainer(\TIC\PlatformBundle\Entity\Trainers $trainers)
    {
        $this->trainers[] = $trainers;

        return $this;
    }

    /**
     * Remove trainers
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainers
     */
    public function removeTrainer(\TIC\PlatformBundle\Entity\Trainers $trainers)
    {
        $this->trainers->removeElement($trainers);
    }

    /**
     * Get trainers
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrainers()
    {
        return $this->trainers;
    }

    /**
     * Add addresses
     *
     * @param \TIC\PlatformBundle\Entity\Addresses $addresses
     * @return Countries
     */
    public function addAddress(\TIC\PlatformBundle\Entity\Addresses $addresses)
    {
        $this->addresses[] = $addresses;

        return $this;
    }

    /**
     * Remove addresses
     *
     * @param \TIC\PlatformBundle\Entity\Addresses $addresses
     */
    public function removeAddress(\TIC\PlatformBundle\Entity\Addresses $addresses)
    {
        $this->addresses->removeElement($addresses);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAddresses()
    {
        return $this->addresses;
    }
}

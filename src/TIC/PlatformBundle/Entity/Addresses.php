<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Addresses
 *
 * @ORM\Table(name="Addresses")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\AddressesRepository")
 */
class Addresses
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
     * @ORM\Column(name="AddressLine1", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Address Line 1 is required")
     * @Assert\Length(max=255)
     *
     */
    private $addressLine1;

    /**
     * @var string
     *
     * @ORM\Column(name="AddressLine2", type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     */
    private $addressLine2;

    /**
     * @var integer
     *
     * @ORM\Column(name="AddressZipCode", type="integer", nullable=true)
     * @Assert\Type(
     *     type="integer"
     * )
     * @Assert\NotBlank(message="Zip Code is Required")
     *
     */
    private $addressZipCode;

    /**
     * @var string
     *
     * @ORM\Column(name="AddressLocality", type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="Locality is required")
     * @Assert\Length(max=255)
     *
     */
    private $addressLocality;

    /**
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Countries", inversedBy="addresses")
     * @ORM\JoinColumn(name="CountryID", nullable=true)
     * @Assert\NotBlank()
     */
    private $countries;

    /**
     * @ORM\OneToMany(targetEntity="Sessions", mappedBy="address")
     */
    private $sessions;

    /**
     * @ORM\OneToOne(targetEntity="ClientAddresses", mappedBy="address")
     */
    private $clientAddresses;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->sessions) == 0;
    }

    /**
     * @return bool
     */
    public function isZipCodeValid()
    {
        return is_int($this->addressZipCode);
    }

    /**
     * @return string
     */
    public function toAgenda()
    {
        return sprintf("%s, %s, %s", $this->addressLine1, $this->addressLocality, $this->countries !== null ? $this->countries->getCountryName() : null);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toAgenda();
    }

    /**
     * @return array
     */
    public function toJSON()
    {
        return array(
            'id' => $this->id,
            'text' => $this->__toString()
        );
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
     * Set addressLine1
     *
     * @param string $addressLine1
     * @return Addresses
     */
    public function setAddressLine1($addressLine1)
    {
        $this->addressLine1 = $addressLine1;

        return $this;
    }

    /**
     * Get addressLine1
     *
     * @return string 
     */
    public function getAddressLine1()
    {
        return $this->addressLine1;
    }

    /**
     * Set addressLine2
     *
     * @param string $addressLine2
     * @return Addresses
     */
    public function setAddressLine2($addressLine2)
    {
        $this->addressLine2 = $addressLine2;

        return $this;
    }

    /**
     * Get addressLine2
     *
     * @return string 
     */
    public function getAddressLine2()
    {
        return $this->addressLine2;
    }

    /**
     * Set addressZipCode
     *
     * @param integer $addressZipCode
     * @return Addresses
     */
    public function setAddressZipCode($addressZipCode)
    {
        $this->addressZipCode = $addressZipCode;

        return $this;
    }

    /**
     * Get addressZipCode
     *
     * @return integer 
     */
    public function getAddressZipCode()
    {
        return $this->addressZipCode;
    }

    /**
     * Set addressLocality
     *
     * @param string $addressLocality
     * @return Addresses
     */
    public function setAddressLocality($addressLocality)
    {
        $this->addressLocality = $addressLocality;

        return $this;
    }

    /**
     * Get addressLocality
     *
     * @return string 
     */
    public function getAddressLocality()
    {
        return $this->addressLocality;
    }

    /**
     * Set addressCountry
     *
     * @param string $addressCountry
     * @return Addresses
     */
    public function setAddressCountry($addressCountry)
    {
        $this->addressCountry = $addressCountry;

        return $this;
    }

    /**
     * Get addressCountry
     *
     * @return string 
     */
    public function getAddressCountry()
    {
        return $this->addressCountry;
    }

    /**
     * Set countries
     *
     * @param \TIC\PlatformBundle\Entity\Countries $countries
     * @return Addresses
     */
    public function setCountries(\TIC\PlatformBundle\Entity\Countries $countries = null)
    {
        $this->countries = $countries;

        return $this;
    }

    /**
     * Get countries
     *
     * @return \TIC\PlatformBundle\Entity\Countries 
     */
    public function getCountries()
    {
        return $this->countries;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add sessions
     *
     * @param \TIC\PlatformBundle\Entity\Sessions $sessions
     * @return Addresses
     */
    public function addSession(\TIC\PlatformBundle\Entity\Sessions $sessions)
    {
        $this->sessions[] = $sessions;

        return $this;
    }

    /**
     * Remove sessions
     *
     * @param \TIC\PlatformBundle\Entity\Sessions $sessions
     */
    public function removeSession(\TIC\PlatformBundle\Entity\Sessions $sessions)
    {
        $this->sessions->removeElement($sessions);
    }

    /**
     * Get sessions
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSessions()
    {
        return $this->sessions;
    }
    
    /**
     * Get clientAddresses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClientAddresses()
    {
        return $this->clientAddresses;
    }

    /**
     * Set clientAddresses
     *
     * @param \TIC\PlatformBundle\Entity\ClientAddresses $clientAddresses
     * @return Addresses
     */
    public function setClientAddresses(\TIC\PlatformBundle\Entity\ClientAddresses $clientAddresses = null)
    {
        $this->clientAddresses = $clientAddresses;

        return $this;
    }
}

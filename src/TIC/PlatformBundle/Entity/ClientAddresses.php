<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ClientAddresses
 *
 * @ORM\Table(name="ClientAddresses")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\ClientAddressesRepository")
 */
class ClientAddresses
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
     * @var boolean
     *
     * @ORM\Column(name="ClientAddressDelivery", type="boolean")
     */
    private $clientAddressDelivery;

    /**
     * @var string
     *
     * @ORM\Column(name="ClientAddressLastname", type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     *
     */
    private $clientAddressLastname;
    
    /**
     * @var string
     *
     * @ORM\Column(name="ClientAddressFirstname", type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     *
     */
    private $clientAddressFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="ClientAddressPhone", type="string", length=255, nullable=true)
     * @Assert\Length(max=255)
     *
     */
    private $clientAddressPhone;

    /**
     * @var Addresses
     *
     * @ORM\OneToOne(targetEntity="TIC\PlatformBundle\Entity\Addresses", cascade={"persist", "remove"}, inversedBy="clientAddresses")
     * @ORM\JoinColumn(name="AddressID", nullable=false)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Clients", inversedBy="clientAddresses", cascade={"persist"})
     * @ORM\JoinColumn(name="ClientID", nullable=false)
     */
    private $client;

    /**
     * @return mixed
     */
    public function isDeletable()
    {
        return $this->address->isDeletable();
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
     * Set clientAddressDelivery
     *
     * @param boolean $clientAddressDelivery
     * @return ClientAddresses
     */
    public function setClientAddressDelivery($clientAddressDelivery)
    {
        $this->clientAddressDelivery = $clientAddressDelivery;

        return $this;
    }

    /**
     * Get clientAddressDelivery
     *
     * @return boolean 
     */
    public function getClientAddressDelivery()
    {
        return $this->clientAddressDelivery;
    }

    /**
     * Set clientAddressLastname
     *
     * @param string $clientAddressLastname
     * @return ClientAddresses
     */
    public function setClientAddressLastname($clientAddressLastname)
    {
        $this->clientAddressLastname = $clientAddressLastname;

        return $this;
    }

    /**
     * Get clientAddressLastname
     *
     * @return string 
     */
    public function getClientAddressLastname()
    {
        return $this->clientAddressLastname;
    }

    /**
     * Set clientAddressFirstname
     *
     * @param string $clientAddressFirstname
     * @return ClientAddresses
     */
    public function setClientAddressFirstname($clientAddressFirstname)
    {
        $this->clientAddressFirstname = $clientAddressFirstname;

        return $this;
    }

    /**
     * Get clientAddressFirstname
     *
     * @return string 
     */
    public function getClientAddressFirstname()
    {
        return $this->clientAddressFirstname;
    }

    /**
     * Set clientAddressPhone
     *
     * @param string $clientAddressPhone
     * @return ClientAddresses
     */
    public function setClientAddressPhone($clientAddressPhone)
    {
        $this->clientAddressPhone = $clientAddressPhone;

        return $this;
    }

    /**
     * Get clientAddressPhone
     *
     * @return string 
     */
    public function getClientAddressPhone()
    {
        return $this->clientAddressPhone;
    }

    /**
     * Set address
     *
     * @param \TIC\PlatformBundle\Entity\Addresses $address
     * @return ClientAddresses
     */
    public function setAddress(\TIC\PlatformBundle\Entity\Addresses $address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \TIC\PlatformBundle\Entity\Addresses 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set client
     *
     * @param \TIC\PlatformBundle\Entity\Clients $client
     * @return ClientAddresses
     */
    public function setClient(\TIC\PlatformBundle\Entity\Clients $client)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \TIC\PlatformBundle\Entity\Clients 
     */
    public function getClient()
    {
        return $this->client;
    }
}

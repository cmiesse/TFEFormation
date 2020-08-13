<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactPeople
 *
 * @ORM\Table(name="ContactPeople")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\ContactPeopleRepository")
 */
class ContactPeople
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
     * @ORM\Column(name="ContactPersonLastname", type="string", length=255)
     */
    private $contactPersonLastname;

    /**
     * @var string
     *
     * @ORM\Column(name="ContactPersonFirstname", type="string", length=255)
     */
    private $contactPersonFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="ContactPersonPhone", type="string", length=255)
     */
    private $contactPersonPhone;

    /**
     * @var string
     *
     * @ORM\Column(name="ContactPersonMail", type="string", length=255)
     */
    private $contactPersonMail;

    /**
     * @var string
     *
     * @ORM\Column(name="ContactPersonFunction", type="string", length=255, nullable=true)
     */
    private $contactPersonFunction;

    /**
     * @var string
     *
     * @ORM\Column(name="ContactPersonLanguage", type="string", length=255)
     */
    private $contactPersonLanguage;

    /**
     * @var string
     *
     * @ORM\Column(name="ContactPersonGender", type="string", length=1)
     */
    private $contactPersonGender;

    /**
     * @var Addresses
     *
     * @ORM\OneToOne(targetEntity="TIC\PlatformBundle\Entity\Addresses", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="AddressID", nullable=false)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Clients", inversedBy="contactPeople", cascade={"persist"})
     * @ORM\JoinColumn(name="ClientID", nullable=false)
     */
    private $client;

    /**
     * @return bool
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
     * Set contactPersonLastname
     *
     * @param string $contactPersonLastname
     * @return ContactPeople
     */
    public function setContactPersonLastname($contactPersonLastname)
    {
        $this->contactPersonLastname = $contactPersonLastname;

        return $this;
    }

    /**
     * Get contactPersonLastname
     *
     * @return string 
     */
    public function getContactPersonLastname()
    {
        return $this->contactPersonLastname;
    }

    /**
     * Set contactPersonFirstname
     *
     * @param string $contactPersonFirstname
     * @return ContactPeople
     */
    public function setContactPersonFirstname($contactPersonFirstname)
    {
        $this->contactPersonFirstname = $contactPersonFirstname;

        return $this;
    }

    /**
     * Get contactPersonFirstname
     *
     * @return string 
     */
    public function getContactPersonFirstname()
    {
        return $this->contactPersonFirstname;
    }

    /**
     * Set contactPersonPhone
     *
     * @param string $contactPersonPhone
     * @return ContactPeople
     */
    public function setContactPersonPhone($contactPersonPhone)
    {
        $this->contactPersonPhone = $contactPersonPhone;

        return $this;
    }

    /**
     * Get contactPersonPhone
     *
     * @return string 
     */
    public function getContactPersonPhone()
    {
        return $this->contactPersonPhone;
    }

    /**
     * Set contactPersonMail
     *
     * @param string $contactPersonMail
     * @return ContactPeople
     */
    public function setContactPersonMail($contactPersonMail)
    {
        $this->contactPersonMail = $contactPersonMail;

        return $this;
    }

    /**
     * Get contactPersonMail
     *
     * @return string 
     */
    public function getContactPersonMail()
    {
        return $this->contactPersonMail;
    }

    /**
     * Set contactPersonFunction
     *
     * @param string $contactPersonFunction
     * @return ContactPeople
     */
    public function setContactPersonFunction($contactPersonFunction)
    {
        $this->contactPersonFunction = $contactPersonFunction;

        return $this;
    }

    /**
     * Get contactPersonFunction
     *
     * @return string 
     */
    public function getContactPersonFunction()
    {
        return $this->contactPersonFunction;
    }

    /**
     * Set contactPersonLanguage
     *
     * @param string $contactPersonLanguage
     * @return ContactPeople
     */
    public function setContactPersonLanguage($contactPersonLanguage)
    {
        $this->contactPersonLanguage = $contactPersonLanguage;

        return $this;
    }

    /**
     * Get contactPersonLanguage
     *
     * @return string 
     */
    public function getContactPersonLanguage()
    {
        return $this->contactPersonLanguage;
    }

    /**
     * Set contactPersonGender
     *
     * @param string $contactPersonGender
     * @return ContactPeople
     */
    public function setContactPersonGender($contactPersonGender)
    {
        $this->contactPersonGender = $contactPersonGender;

        return $this;
    }

    /**
     * Get contactPersonGender
     *
     * @return string 
     */
    public function getContactPersonGender()
    {
        return $this->contactPersonGender;
    }

    /**
     * Set address
     *
     * @param \TIC\PlatformBundle\Entity\Addresses $address
     * @return ContactPeople
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
     * @return ContactPeople
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

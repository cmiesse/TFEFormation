<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Clients
 *
 * @ORM\Table(name="Clients")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\ClientsRepository")
 */
class Clients
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
     * @ORM\Column(name="ClientName", type="string", length=255)
     * @Assert\NotBlank(message="A name is required")
     * @Assert\Length(max=255)
     */
    private $clientName;

    /**
     * @var string
     *
     * @ORM\Column(name="ClientTVANumber", type="string", length=255)
     * @Assert\NotBlank(message="VAT Number is required")
     * @Assert\Length(max=255)
     *
     */
    private $clientTVANumber;

    /**
     * @var string
     *
     * @ORM\Column(name="ClientAbbreviation", type="string", length=255)
     * @Assert\NotBlank(message="Abbreviation of the client Name is required")
     * @Assert\Length(max=255)
     *
     */
    private $clientAbbreviation;

    /**
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\ClientsCategories", inversedBy="clients")
     * @ORM\JoinColumn(name="ClientCategoryID", nullable=false)
     */
    private $clientCategory;

    /**
     * @var ClientAddresses[]
     * 
     * @ORM\OneToMany(targetEntity="TIC\PlatformBundle\Entity\ClientAddresses", mappedBy="client", cascade={"persist", "remove"})
     *
     */
    private $clientAddresses;

    /**
     * @ORM\OneToMany(targetEntity="TIC\PlatformBundle\Entity\ContactPeople", mappedBy="client", cascade={"persist", "remove"})
     *
     */
    private $contactPeople;

    /**
     * @ORM\OneToMany(targetEntity="TIC\PlatformBundle\Entity\Contracts", mappedBy="client", cascade={"remove"})
     *
     */
    private $contracts;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->contracts) == 0;
    }

    public function getSingleContactPerson()
    {
        if (count($this->contactPeople) > 0) {
            return $this->contactPeople[0];
        }
        return new ContactPeople();
    }

    public function setSingleContactPerson(ContactPeople $contactPeople)
    {
        $contactPeople->setClient($this);
        $this->contactPeople[0] = $contactPeople;
    }

    /**
     * @return ClientAddresses
     */
    public function getSingleAddress()
    {
        if (count($this->clientAddresses) > 0) {
            return $this->clientAddresses[0];
        }
        return new ClientAddresses();
    }

    public function setSingleAddress(ClientAddresses $clientAddresses)
    {
        $clientAddresses->setClient($this);
        $this->clientAddresses[0] = $clientAddresses;
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
     * Set clientName
     *
     * @param string $clientName
     * @return Clients
     */
    public function setClientName($clientName)
    {
        $this->clientName = $clientName;

        return $this;
    }

    /**
     * Get clientName
     *
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * Set clientTVANumber
     *
     * @param string $clientTVANumber
     * @return Clients
     */
    public function setClientTVANumber($clientTVANumber)
    {
        $this->clientTVANumber = $clientTVANumber;

        return $this;
    }

    /**
     * Get clientTVANumber
     *
     * @return string
     */
    public function getClientTVANumber()
    {
        return $this->clientTVANumber;
    }

    /**
     * Set clientAbbreviation
     *
     * @param string $clientAbbreviation
     * @return Clients
     */
    public function setClientAbbreviation($clientAbbreviation)
    {
        $this->clientAbbreviation = $clientAbbreviation;

        return $this;
    }

    /**
     * Get clientAbbreviation
     *
     * @return string
     */
    public function getClientAbbreviation()
    {
        return $this->clientAbbreviation;
    }

    /**
     * Set clientCategory
     *
     * @param \TIC\PlatformBundle\Entity\ClientsCategories $clientCategory
     * @return Clients
     */
    public function setClientCategory(\TIC\PlatformBundle\Entity\ClientsCategories $clientCategory)
    {
        $this->clientCategory = $clientCategory;

        return $this;
    }

    /**
     * Get clientCategory
     *
     * @return \TIC\PlatformBundle\Entity\ClientsCategories
     */
    public function getClientCategory()
    {
        return $this->clientCategory;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clientAddresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contactPeople = new \Doctrine\Common\Collections\ArrayCollection();
        $this->contracts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add clientAddresses
     *
     * @param \TIC\PlatformBundle\Entity\ClientAddresses $clientAddresses
     * @return Clients
     */
    public function addClientAddress(\TIC\PlatformBundle\Entity\ClientAddresses $clientAddresses)
    {
        $this->clientAddresses[] = $clientAddresses;
        $clientAddresses->setClient($this);
        return $this;
    }

    /**
     * Remove clientAddresses
     *
     * @param \TIC\PlatformBundle\Entity\ClientAddresses $clientAddresses
     */
    public function removeClientAddress(\TIC\PlatformBundle\Entity\ClientAddresses $clientAddresses)
    {
        $this->clientAddresses->removeElement($clientAddresses);
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
     * Add contactPeople
     *
     * @param \TIC\PlatformBundle\Entity\ContactPeople $contactPeople
     * @return Clients
     */
    public function addContactPerson(\TIC\PlatformBundle\Entity\ContactPeople $contactPeople)
    {
        $this->contactPeople[] = $contactPeople;
        $contactPeople->setClient($this);

        return $this;
    }

    /**
     * Remove contactPeople
     *
     * @param \TIC\PlatformBundle\Entity\ContactPeople $contactPeople
     */
    public function removeContactPerson(\TIC\PlatformBundle\Entity\ContactPeople $contactPeople)
    {
        $this->contactPeople->removeElement($contactPeople);
    }

    /**
     * Get contactPeople
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContactPeople()
    {
        return $this->contactPeople;
    }

    /**
     * Add contracts
     *
     * @param \TIC\PlatformBundle\Entity\Contracts $contracts
     * @return Clients
     */
    public function addContract(\TIC\PlatformBundle\Entity\Contracts $contracts)
    {
        $this->contracts[] = $contracts;
        return $this;
    }

    /**
     * Remove contracts
     *
     * @param \TIC\PlatformBundle\Entity\Contracts $contracts
     */
    public function removeContract(\TIC\PlatformBundle\Entity\Contracts $contracts)
    {
        $this->contracts->removeElement($contracts);
    }

    /**
     * Get contracts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContracts()
    {
        return $this->contracts;
    }
}

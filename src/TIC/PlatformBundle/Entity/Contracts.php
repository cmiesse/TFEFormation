<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contracts
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\ContractsRepository")
 */
class Contracts
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
     * @ORM\Column(name="ContactNumber", type="string", length=255)
     * @Assert\NotBlank(message="Contract number is required")
     * @Assert\Length(max=255)
     *
     */
    private $contractNumber;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ContractExtendedEndDate", type="date", nullable=true)
     * @Assert\DateTime()
     */
    private $contractExtendedEndDate;

    /**
     * @var integer
     * @Assert\Type(type="numeric", message="Must be a numeric value")
     * @Assert\NotBlank(message="Total amount is required")
     * @ORM\Column(name="ContractTotalAmount", type="float")
     */
    private $contractTotalAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="ContractDailyAmount", type="float")
     * @Assert\Type(type="numeric", message="Must be a numeric value")
     * @Assert\NotBlank(message="Daily amount is required")
     */
    private $contractDailyAmount;

    /**
     * @var integer
     *
     * @ORM\Column(name="ContractDaysNumber", type="integer")
     * @Assert\Type(type="integer", message="Must be an numeric value")
     * @Assert\NotBlank(message="Days Number is required")
     */
    private $contractDaysNumber;

    /**
     * @var integer
     *
     * @ORM\Column(name="ContractBalance", type="float")
     * @Assert\Type(type="numeric", message="Must be a numeric value")
     * @Assert\NotBlank(message="Balance is required")
     */
    private $contractBalance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ContractBeginDate", type="date")
     * @Assert\DateTime()
     */
    private $contractBeginDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ContractEndDate", type="date")
     * @Assert\DateTime()
     */
    private $contractEndDate;

    /**
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Clients", inversedBy="contracts")
     * @ORM\JoinColumn(name="ClientID", nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity="Sessions", mappedBy="contract")
     */
    private $sessions;

    /**
     * @ORM\ManyToOne(targetEntity="FacturationMode", inversedBy="contracts")
     * @ORM\JoinColumn(name="FacturationModeID", referencedColumnName="FacturationModeID", nullable=false)
     *
     * @Assert\NotBlank()
     */
    private $facturationMode;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->sessions) == 0;
    }

    /**
     * Contracts constructor.
     */
    public function __construct()
    {
        $this->contractDaysNumber = 0;
        $this->contractDailyAmount = 0;
    }

    /**
     * @Assert\True(
     *     message="dates.invalid"
     * )
     */
    public function isDatesValid()
    {
        return $this->contractEndDate >= $this->contractBeginDate && ($this->contractExtendedEndDate === null || $this->contractExtendedEndDate >= $this->contractEndDate);
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
     * Set contractNumber
     *
     * @param string $contractNumber
     * @return Contracts
     */
    public function setContractNumber($contractNumber)
    {
        $this->contractNumber = $contractNumber;

        return $this;
    }

    /**
     * Get contractNumber
     *
     * @return string 
     */
    public function getContractNumber()
    {
        return $this->contractNumber;
    }

    /**
     * Set contractExtendedEndDate
     *
     * @param \DateTime $contractExtendedEndDate
     * @return Contracts
     */
    public function setContractExtendedEndDate($contractExtendedEndDate)
    {
        $this->contractExtendedEndDate = $contractExtendedEndDate;

        return $this;
    }

    /**
     * Get contractExtendedEndDate
     *
     * @return \DateTime 
     */
    public function getContractExtendedEndDate()
    {
        return $this->contractExtendedEndDate;
    }

    /**
     * Set contractTotalAmount
     *
     * @param integer $contractTotalAmount
     * @return Contracts
     */
    public function setContractTotalAmount($contractTotalAmount)
    {
        $this->contractTotalAmount = $contractTotalAmount;

        return $this;
    }

    /**
     * Get contractTotalAmount
     *
     * @return integer 
     */
    public function getContractTotalAmount()
    {
        return $this->contractTotalAmount;
    }

    /**
     * Set contractDailyAmount
     *
     * @param integer $contractDailyAmount
     * @return Contracts
     */
    public function setContractDailyAmount($contractDailyAmount)
    {
        $this->contractDailyAmount = $contractDailyAmount;

        return $this;
    }

    /**
     * Get contractDailyAmount
     *
     * @return integer 
     */
    public function getContractDailyAmount()
    {
        return $this->contractDailyAmount;
    }

    /**
     * Set contractDaysNumber
     *
     * @param integer $contractDaysNumber
     * @return Contracts
     */
    public function setContractDaysNumber($contractDaysNumber)
    {
        $this->contractDaysNumber = $contractDaysNumber;

        return $this;
    }

    /**
     * Get contractDaysNumber
     *
     * @return integer 
     */
    public function getContractDaysNumber()
    {
        return $this->contractDaysNumber;
    }

    /**
     * Set contractBalance
     *
     * @param integer $contractBalance
     * @return Contracts
     */
    public function setContractBalance($contractBalance)
    {
        $this->contractBalance = $contractBalance;

        return $this;
    }

    /**
     * Get contractBalance
     *
     * @return integer 
     */
    public function getContractBalance()
    {
        return $this->contractBalance;
    }

    /**
     * Set contractFacturationMode
     *
     * @param string $contractFacturationMode
     * @return Contracts
     */
    public function setContractFacturationMode($contractFacturationMode)
    {
        $this->contractFacturationMode = $contractFacturationMode;

        return $this;
    }

    /**
     * Get contractFacturationMode
     *
     * @return string 
     */
    public function getContractFacturationMode()
    {
        return $this->contractFacturationMode;
    }

    /**
     * Set contractBeginDate
     *
     * @param \DateTime $contractBeginDate
     * @return Contracts
     */
    public function setContractBeginDate($contractBeginDate)
    {
        $this->contractBeginDate = $contractBeginDate;

        return $this;
    }

    /**
     * Get contractBeginDate
     *
     * @return \DateTime 
     */
    public function getContractBeginDate()
    {
        return $this->contractBeginDate;
    }

    /**
     * Set contractEndDate
     *
     * @param \DateTime $contractEndDate
     * @return Contracts
     */
    public function setContractEndDate($contractEndDate)
    {
        $this->contractEndDate = $contractEndDate;

        return $this;
    }

    /**
     * Get contractEndDate
     *
     * @return \DateTime 
     */
    public function getContractEndDate()
    {
        return $this->contractEndDate;
    }

    /**
     * Set client
     *
     * @param \TIC\PlatformBundle\Entity\Clients $client
     * @return Contracts
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

    /**
     * Add sessions
     *
     * @param \TIC\PlatformBundle\Entity\Sessions $sessions
     * @return Contracts
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
     * Set facturationMode
     *
     * @param \TIC\PlatformBundle\Entity\FacturationMode $facturationMode
     * @return Contracts
     */
    public function setFacturationMode(\TIC\PlatformBundle\Entity\FacturationMode $facturationMode)
    {
        $this->facturationMode = $facturationMode;

        return $this;
    }

    /**
     * Get facturationMode
     *
     * @return \TIC\PlatformBundle\Entity\FacturationMode 
     */
    public function getFacturationMode()
    {
        return $this->facturationMode;
    }
}

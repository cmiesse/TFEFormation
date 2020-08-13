<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Sessions
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\SessionsRepository")
 */
class Sessions
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
     * @var float
     * @Assert\NotBlank(message="Daily amount is required")
     * @ORM\Column(name="SessionDailyAmount", type="float")
     */
    private $sessionDailyAmount;

    /**
     * @var float
     * @Assert\GreaterThan(
     *     value="0"
     * )
     * @ORM\Column(name="SessionNumberOfDays", type="float", nullable=true)
     */
    private $sessionNumberOfDays;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Addresses", cascade={"persist"}, inversedBy="sessions")
     * @ORM\JoinColumn(name="AddressID", nullable=false)
     */
    private $address;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Trainings", inversedBy="sessions")
     * @ORM\JoinColumn(name="TrainingID", nullable=false)
     */
    private $training;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Languages", inversedBy="sessions")
     * @ORM\JoinColumn(name="LanguageID", nullable=false)
     */
    private $language;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToMany(targetEntity="TIC\PlatformBundle\Entity\Trainers", inversedBy="sessions")
     * @ORM\JoinColumn(name="TrainerID", nullable=false)
     */
    private $trainer;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Contracts", inversedBy="sessions")
     * @ORM\JoinColumn(name="ContractID", nullable=false)
     */
    private $contract;

    /**
     * @var RangeDates
     *
     * @Assert\NotBlank()
     * @ORM\OneToOne(targetEntity="TIC\PlatformBundle\Entity\RangeDates", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="RangeDateID", nullable=false)
     */
    private $RangeDate;

    /**
     * @Assert\NotBlank()
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\PerformancesTypes", inversedBy="sessions")
     * @ORM\JoinColumn(name="PerformanceTypeID", nullable=false)
     */
    private $PerformanceType;
    
    /**
     * @ORM\OneToMany(targetEntity="TIC\PlatformBundle\Entity\events", mappedBy="session", cascade={"remove"})
     */
    private $events;

    /**
     * @Assert\True(
     *     message="dates.invalid"
     * )
     */
    public function isDatesValid()
    {
        return $this->RangeDate->getRangeDateEnd() >= $this->RangeDate->getRangeDateBegin();
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
     * Set sessionDailyAmount
     *
     * @param float $sessionDailyAmount
     * @return Sessions
     */
    public function setSessionDailyAmount($sessionDailyAmount)
    {
        $this->sessionDailyAmount = $sessionDailyAmount;

        return $this;
    }

    /**
     * Get sessionDailyAmount
     *
     * @return float 
     */
    public function getSessionDailyAmount()
    {
        return $this->sessionDailyAmount;
    }

    /**
     * Set address
     *
     * @param \TIC\PlatformBundle\Entity\Addresses $address
     * @return Sessions
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
     * Set training
     *
     * @param \TIC\PlatformBundle\Entity\Trainings $training
     * @return Sessions
     */
    public function setTraining(\TIC\PlatformBundle\Entity\Trainings $training)
    {
        $this->training = $training;

        return $this;
    }

    /**
     * Get training
     *
     * @return \TIC\PlatformBundle\Entity\Trainings 
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * Set language
     *
     * @param \TIC\PlatformBundle\Entity\Languages $language
     * @return Sessions
     */
    public function setLanguage(\TIC\PlatformBundle\Entity\Languages $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return \TIC\PlatformBundle\Entity\Languages 
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set trainer
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainer
     * @return Sessions
     */
    public function setTrainer(\TIC\PlatformBundle\Entity\Trainers $trainer)
    {
        $this->trainer = $trainer;

        return $this;
    }

    /**
     * Get trainer
     *
     * @return \TIC\PlatformBundle\Entity\Trainers 
     */
    public function getTrainer()
    {
        return $this->trainer;
    }

    /**
     * Set contract
     *
     * @param \TIC\PlatformBundle\Entity\Contracts $contract
     * @return Sessions
     */
    public function setContract(\TIC\PlatformBundle\Entity\Contracts $contract)
    {
        $this->contract = $contract;

        return $this;
    }

    /**
     * Get contract
     *
     * @return \TIC\PlatformBundle\Entity\Contracts 
     */
    public function getContract()
    {
        return $this->contract;
    }

    /**
     * Set RangeDate
     *
     * @param \TIC\PlatformBundle\Entity\RangeDates $rangeDate
     * @return Sessions
     */
    public function setRangeDate(\TIC\PlatformBundle\Entity\RangeDates $rangeDate)
    {
        $this->RangeDate = $rangeDate;

        return $this;
    }

    /**
     * Get RangeDate
     *
     * @return \TIC\PlatformBundle\Entity\RangeDates 
     */
    public function getRangeDate()
    {
        return $this->RangeDate;
    }

    /**
     * Set PerformanceType
     *
     * @param \TIC\PlatformBundle\Entity\PerformancesTypes $performanceType
     * @return Sessions
     */
    public function setPerformanceType(\TIC\PlatformBundle\Entity\PerformancesTypes $performanceType)
    {
        $this->PerformanceType = $performanceType;

        return $this;
    }

    /**
     * Get PerformanceType
     *
     * @return \TIC\PlatformBundle\Entity\PerformancesTypes 
     */
    public function getPerformanceType()
    {
        return $this->PerformanceType;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trainer = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add trainer
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainer
     * @return Sessions
     */
    public function addTrainer(\TIC\PlatformBundle\Entity\Trainers $trainer)
    {
        $this->trainer[] = $trainer;

        return $this;
    }

    /**
     * Remove trainer
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainer
     */
    public function removeTrainer(\TIC\PlatformBundle\Entity\Trainers $trainer)
    {
        $this->trainer->removeElement($trainer);
    }

    /**
     * Set Category
     *
     * @param \TIC\PlatformBundle\Entity\PerformancesTypes $category
     * @return Sessions
     */
    public function setCategory(\TIC\PlatformBundle\Entity\PerformancesTypes $category)
    {
        $this->Category = $category;

        return $this;
    }

    /**
     * Get Category
     *
     * @return \TIC\PlatformBundle\Entity\PerformancesTypes 
     */
    public function getCategory()
    {
        return $this->Category;
    }

    /**
     * Add events
     *
     * @param \TIC\PlatformBundle\Entity\events $events
     * @return Sessions
     */
    public function addEvent(\TIC\PlatformBundle\Entity\events $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \TIC\PlatformBundle\Entity\events $events
     */
    public function removeEvent(\TIC\PlatformBundle\Entity\events $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Set sessionNumberOfDays
     *
     * @param integer $sessionNumberOfDays
     * @return Sessions
     */
    public function setSessionNumberOfDays($sessionNumberOfDays)
    {
        $this->sessionNumberOfDays = $sessionNumberOfDays;

        return $this;
    }

    /**
     * Get sessionNumberOfDays
     *
     * @return integer 
     */
    public function getSessionNumberOfDays()
    {
        return $this->sessionNumberOfDays;
    }
}

<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Employer
 *
 * @ORM\Table(name="Employers")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Repository\EmployerRepository")
 */
class Employer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="EmployerID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $employerID;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="EmployerName", type="string", nullable=false, length=255)
     */
    private $employerName;

    /**
     * @ORM\OneToMany(targetEntity="Trainers", mappedBy="employer")
     */
    private $trainers;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->trainers) == 0;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trainers = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get employerID
     *
     * @return integer 
     */
    public function getEmployerID()
    {
        return $this->employerID;
    }

    /**
     * Set employerName
     *
     * @param string $employerName
     * @return Employer
     */
    public function setEmployerName($employerName)
    {
        $this->employerName = $employerName;

        return $this;
    }

    /**
     * Get employerName
     *
     * @return string 
     */
    public function getEmployerName()
    {
        return $this->employerName;
    }

    /**
     * Add trainers
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainers
     * @return Employer
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
}

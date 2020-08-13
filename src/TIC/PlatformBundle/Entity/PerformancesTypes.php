<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PerformancesTypes
 *
 * @ORM\Table(name="PerformancesTypes")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Repository\PerformanceTypeRepository")
 */
class PerformancesTypes
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
     * @ORM\Column(name="PerformanceType", type="string", length=255)
     */
    private $performanceType;

    /**
     * @ORM\OneToMany(targetEntity="Sessions", mappedBy="PerformanceType")
     */
    private $sessions;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->sessions) == 0;
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
     * Set performanceType
     *
     * @param string $performanceType
     * @return PerformancesTypes
     */
    public function setPerformanceType($performanceType)
    {
        $this->performanceType = $performanceType;

        return $this;
    }

    /**
     * Get performanceType
     *
     * @return string 
     */
    public function getPerformanceType()
    {
        return $this->performanceType;
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
     * @return PerformancesTypes
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
}

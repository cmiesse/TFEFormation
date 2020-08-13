<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FacturationMode
 *
 * @ORM\Table(name="FacturationModes")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Repository\FacturationModeRepository")
 */
class FacturationMode
{
    /**
     * @var integer
     *
     * @ORM\Column(name="FacturationModeID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $facturationModeID;

    /**
     * @var string
     *
     * @ORM\Column(name="FacturationModeLabel", type="string", nullable=false, length=255)
     * @Assert\NotBlank()
     */
    private $facturationModeLabel;

    /**
     * @ORM\OneToMany(targetEntity="Contracts", mappedBy="facturationMode")
     */
    private $contracts;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->contracts) == 0;
    }

    /**
     * Get facturationModeID
     *
     * @return integer 
     */
    public function getFacturationModeID()
    {
        return $this->facturationModeID;
    }

    /**
     * Set facturationModeLabel
     *
     * @param string $facturationModeLabel
     * @return FacturationMode
     */
    public function setFacturationModeLabel($facturationModeLabel)
    {
        $this->facturationModeLabel = $facturationModeLabel;

        return $this;
    }

    /**
     * Get facturationModeLabel
     *
     * @return string 
     */
    public function getFacturationModeLabel()
    {
        return $this->facturationModeLabel;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->contracts = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add contracts
     *
     * @param \TIC\PlatformBundle\Entity\Contracts $contracts
     * @return FacturationMode
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

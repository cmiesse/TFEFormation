<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trainings
 *
 * @ORM\Table(name="Trainings")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\TrainingsRepository")
 */
class Trainings
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
     * @Assert\NotBlank(message="Name Required")
     * @ORM\Column(name="TrainingName", type="string", length=255)
     */
    private $trainingName;

    /**
     * @var boolean
     *
     * @ORM\Column(name="TrainingActive", type="boolean", nullable=false)
     */
    private $trainingActive;

    /**
     * @var string
     *
     * @ORM\Column(name="TrainingLink", type="string", length=255, nullable=true)
     */
    private $trainingLink;

    /**
     * @ORM\ManyToMany(targetEntity="TIC\PlatformBundle\Entity\Tools", inversedBy="trainings")
     * @Assert\Count(
     *     min="1"
     * )
     */
    private $tools;

    /**
     * @ORM\OneToMany(targetEntity="Sessions", mappedBy="training", mappedBy="training")
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
     * Set trainingName
     *
     * @param string $trainingName
     * @return Trainings
     */
    public function setTrainingName($trainingName)
    {
        $this->trainingName = $trainingName;

        return $this;
    }

    /**
     * Get trainingName
     *
     * @return string 
     */
    public function getTrainingName()
    {
        return $this->trainingName;
    }

    /**
     * Set trainingLink
     *
     * @param string $trainingLink
     * @return Trainings
     */
    public function setTrainingLink($trainingLink)
    {
        $this->trainingLink = $trainingLink;

        return $this;
    }

    /**
     * Get trainingLink
     *
     * @return string 
     */
    public function getTrainingLink()
    {
        return $this->trainingLink;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tools = new \Doctrine\Common\Collections\ArrayCollection();
        $this->trainingActive = true;
    }

    /**
     * Add tools
     *
     * @param \TIC\PlatformBundle\Entity\Tools $tools
     * @return Trainings
     */
    public function addTool(\TIC\PlatformBundle\Entity\Tools $tools)
    {
        $this->tools[] = $tools;

        return $this;
    }

    /**
     * Remove tools
     *
     * @param \TIC\PlatformBundle\Entity\Tools $tools
     */
    public function removeTool(\TIC\PlatformBundle\Entity\Tools $tools)
    {
        $this->tools->removeElement($tools);
    }

    /**
     * Get tools
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTools()
    {
        return $this->tools;
    }

    /**
     * Add sessions
     *
     * @param \TIC\PlatformBundle\Entity\Sessions $sessions
     * @return Trainings
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
     * Set trainingActive
     *
     * @param boolean $trainingActive
     * @return Trainings
     */
    public function setTrainingActive($trainingActive)
    {
        $this->trainingActive = $trainingActive;

        return $this;
    }

    /**
     * Get trainingActive
     *
     * @return boolean 
     */
    public function getTrainingActive()
    {
        return $this->trainingActive;
    }
}

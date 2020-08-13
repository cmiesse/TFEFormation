<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tools
 *
 * @ORM\Table(name="Tools")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\ToolsRepository")
 */
class Tools
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
     * @ORM\Column(name="ToolName", type="string", length=255)
     */
    private $toolName;

    /**
     * @ORM\ManyToMany(targetEntity="Trainings", mappedBy="tools")
     */
    private $trainings;

    /**
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Editor", inversedBy="tools")
     * @ORM\JoinColumn(name="EditorID", referencedColumnName="EditorID", nullable=true)
     */
    private $editor;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->trainings) == 0;
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
     * Set toolName
     *
     * @param string $toolName
     * @return Tools
     */
    public function setToolName($toolName)
    {
        $this->toolName = $toolName;

        return $this;
    }

    /**
     * Get toolName
     *
     * @return string 
     */
    public function getToolName()
    {
        return $this->toolName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trainings = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add trainings
     *
     * @param \TIC\PlatformBundle\Entity\Trainings $trainings
     * @return Tools
     */
    public function addTraining(\TIC\PlatformBundle\Entity\Trainings $trainings)
    {
        $this->trainings[] = $trainings;

        return $this;
    }

    /**
     * Remove trainings
     *
     * @param \TIC\PlatformBundle\Entity\Trainings $trainings
     */
    public function removeTraining(\TIC\PlatformBundle\Entity\Trainings $trainings)
    {
        $this->trainings->removeElement($trainings);
    }

    /**
     * Get trainings
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrainings()
    {
        return $this->trainings;
    }

    /**
     * Set editor
     *
     * @param \TIC\PlatformBundle\Entity\Editor $editor
     * @return Tools
     */
    public function setEditor(\TIC\PlatformBundle\Entity\Editor $editor = null)
    {
        $this->editor = $editor;

        return $this;
    }

    /**
     * Get editor
     *
     * @return \TIC\PlatformBundle\Entity\Editor 
     */
    public function getEditor()
    {
        return $this->editor;
    }
}

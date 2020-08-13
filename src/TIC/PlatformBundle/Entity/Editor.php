<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Editor
 *
 * @ORM\Table(name="Editors")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Repository\EditorRepository")
 * @UniqueEntity("editorName")
 */
class Editor
{
    /**
     * @var integer
     *
     * @ORM\Column(name="EditorID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $editorID;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="EditorName", type="string", nullable=false, length=255)
     */
    private $editorName;

    /**
     * @ORM\OneToMany(targetEntity="TIC\PlatformBundle\Entity\Tools", mappedBy="editor")
     */
    private $tools;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->tools) == 0;
    }

    /**
     * Get editorID
     *
     * @return integer 
     */
    public function getEditorID()
    {
        return $this->editorID;
    }

    /**
     * Set editorName
     *
     * @param string $editorName
     * @return Editor
     */
    public function setEditorName($editorName)
    {
        $this->editorName = $editorName;

        return $this;
    }

    /**
     * Get editorName
     *
     * @return string 
     */
    public function getEditorName()
    {
        return $this->editorName;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tools = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tools
     *
     * @param \TIC\PlatformBundle\Entity\Tools $tools
     * @return Editor
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
}

<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Languages
 *
 * @ORM\Table(name="Languages")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\LanguagesRepository")
 */
class Languages
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
     * @ORM\Column(name="Language", type="string", length=255)
     */
    private $language;

    /**
     * @ORM\ManyToMany(targetEntity="TIC\PlatformBundle\Entity\Trainers", mappedBy="languages")
     */
    private $trainers;

    /**
     * @ORM\OneToMany(targetEntity="TIC\PlatformBundle\Entity\Sessions", mappedBy="language")
     */
    private $sessions;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->trainers) == 0 && count($this->sessions) == 0;
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
     * Set language
     *
     * @param string $language
     * @return Languages
     */
    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get language
     *
     * @return string 
     */
    public function getLanguage()
    {
        return $this->language;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->trainers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add trainers
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainers
     * @return Languages
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

    /**
     * Add sessions
     *
     * @param \TIC\PlatformBundle\Entity\Sessions $sessions
     * @return Languages
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

<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\ParameterBag;


/**
 * events
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\eventsRepository")
 */
class events
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
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="CalendarEventID", type="string", nullable=true, length=255)
     */
    private $calendarEventID;

    /**
     * @var Trainers
     *
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Trainers", inversedBy="events")
     * @ORM\JoinColumn(name="TrainerID", nullable=true)
     */
    private $trainer;

    /**
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Sessions", inversedBy="events")
     * @ORM\JoinColumn(name="SessionID", nullable=true)
     */
    private $session;

    /**
     * @return array
     */
    public function toJSON()
    {
        return array(
            'id' => $this->getId(),
            'text' => $this->getText(),
            'start_date' => $this->getStartDate()->format("Y-m-d H:i"),
            'end_date' => $this->getEndDate()->format("Y-m-d H:i"),
            'TrainerID' => $this->getTrainer() ? $this->getTrainer()->getId() : null,
            'color' => $this->getTrainer() ? $this->getTrainer()->getTrainerColor() : "#0E64A0",
            'textColor' => $this->getTrainer() ? $this->getTrainer()->getTrainerTextColor() : "#FFFFFF"
        );
    }

    public function initFromScheduler($id, ParameterBag $data)
    {
        $fields = array(
            "text" => "setText",
        );

        foreach ($fields as $field => $method) {
            $elem = $data->get(sprintf("%s_%s", $id, $field));
            if (isset($elem)) {
                $this->$method($elem);
            }
        }

        $dateFields = array(
            "start_date" => "setStartDate",
            "end_date" => "setEndDate",
        );

        foreach ($dateFields as $field => $method) {
            $elem = $data->get(sprintf("%s_%s", $id, $field));
            if (isset($elem)) {
                $this->$method(new \DateTime($elem));
            }
        }
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
     * Set startDate
     *
     * @param \DateTime $startDate
     * @return events
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     * @return events
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return events
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set session
     *
     * @param \TIC\PlatformBundle\Entity\Sessions $session
     * @return events
     */
    public function setSession(\TIC\PlatformBundle\Entity\Sessions $session = null)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * Get session
     *
     * @return \TIC\PlatformBundle\Entity\Sessions
     */
    public function getSession()
    {
        return $this->session;
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'start_date' => $this->startDate->format('Y-m-d H:i'),
            'end_date' => $this->endDate->format('Y-m-d H:i'),
            'text' => $this->text . " " . (($this->trainer !== null) ? $this->trainer->__toString() : null),
            'trainer' => $this->trainer !== null ? $this->trainer->getId() : null,
            'session' => $this->session !== null ? $this->session->getId() : null
        );
    }


    /**
     * Set trainer
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainer
     * @return events
     */
    public function setTrainer(\TIC\PlatformBundle\Entity\Trainers $trainer = null)
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
     * Set calendarEventID
     *
     * @param string $calendarEventID
     * @return events
     */
    public function setCalendarEventID($calendarEventID)
    {
        $this->calendarEventID = $calendarEventID;

        return $this;
    }

    /**
     * Get calendarEventID
     *
     * @return string 
     */
    public function getCalendarEventID()
    {
        return $this->calendarEventID;
    }
}

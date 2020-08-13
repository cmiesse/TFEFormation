<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RangeDates
 *
 * @ORM\Table(name="RangeDates")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\RangeDatesRepository")
 */
class RangeDates
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
     * @ORM\Column(name="RangeDateBegin", type="datetime")
     */
    private $rangeDateBegin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="RangeDateEnd", type="datetime")
     */
    private $rangeDateEnd;


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
     * Set rangeDateBegin
     *
     * @param \DateTime $rangeDateBegin
     * @return RangeDates
     */
    public function setRangeDateBegin($rangeDateBegin)
    {
        $this->rangeDateBegin = $rangeDateBegin;

        return $this;
    }

    /**
     * Get rangeDateBegin
     *
     * @return \DateTime 
     */
    public function getRangeDateBegin()
    {
        return $this->rangeDateBegin;
    }

    /**
     * Set rangeDateEnd
     *
     * @param \DateTime $rangeDateEnd
     * @return RangeDates
     */
    public function setRangeDateEnd($rangeDateEnd)
    {
        $this->rangeDateEnd = $rangeDateEnd;

        return $this;
    }

    /**
     * Get rangeDateEnd
     *
     * @return \DateTime 
     */
    public function getRangeDateEnd()
    {
        return $this->rangeDateEnd;
    }
}

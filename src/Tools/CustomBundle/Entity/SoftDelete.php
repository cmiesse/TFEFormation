<?php

namespace Tools\CustomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\MappedSuperclass;

/**
 * SoftDelete
 *
 * @MappedSuperclass
 */
abstract class SoftDelete
{
    /**
     * @var \Datetime
     *
     * @ORM\Column(name="DeletedAt", type="datetime", nullable=true)
     */
    private $deletedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="DeletedBy", type="string", nullable=true, length=255)
     */
    private $deletedBy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="Active", type="boolean", nullable=false)
     */
    private $active;

    /**
     * @return bool
     */
    public abstract function isDeletable();

    /**
     * SoftDelete constructor.
     */
    public function __construct()
    {
        $this->deletedAt = null;
        $this->deletedBy = null;
        $this->active = true;
    }

    /**
     * @param $user
     */
    public function toggleDelete($user = null)
    {
        if ($this->deletedAt === null) {
            $this->deletedAt = new \DateTime();
            $this->deletedBy = $user ? $user->getEmail() : 'localhost';
        } else {
            $this->deletedAt = null;
            $this->deletedBy = null;
        }
    }

    public function toggleActive()
    {
        $this->active = !$this->active;
    }

    /**
     * @return bool
     */
    public function isDeleted()
    {
        return !($this->deletedBy === null && $this->deletedAt === null);
    }

    /**
     * Set deletedAt
     *
     * @param \DateTime $deletedAt
     *
     * @return SoftDelete
     */
    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    /**
     * Get deletedAt
     *
     * @return \DateTime
     */
    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    /**
     * Set deletedBy
     *
     * @param string $deletedBy
     *
     * @return SoftDelete
     */
    public function setDeletedBy($deletedBy)
    {
        $this->deletedBy = $deletedBy;

        return $this;
    }

    /**
     * Get deletedBy
     *
     * @return string
     */
    public function getDeletedBy()
    {
        return $this->deletedBy;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return SoftDelete
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }
}

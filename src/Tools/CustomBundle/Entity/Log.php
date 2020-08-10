<?php
/**
 * Created by PhpStorm.
 * Date: 19-05-16
 */

namespace Tools\CustomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Log
 *
 * @ORM\Table(name="Logs")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Log
{
    /**
     * @var integer
     *
     * @ORM\Column(name="LogID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $logID;

    /**
     * @var \Datetime
     *
     * @ORM\Column(name="LogDateTime", type="datetime", nullable=false)
     */
    private $logDateTime;

    /**
     * @var string
     *
     * @ORM\Column(name="LogEmail", type="string", nullable=false, length=255)
     */
    private $logEmail;

    /**
     * @var string
     *
     * @ORM\Column(name="LogTable", type="string", nullable=false, length=255)
     */
    private $logTable;

    /**
     * @var string
     *
     * @ORM\Column(name="LogField", type="string", nullable=false, length=255)
     */
    private $logField;

    /**
     * @var string
     *
     * @ORM\Column(name="LogOldValue", type="text", nullable=true)
     */
    private $logOldValue;

    /**
     * @var string
     *
     * @ORM\Column(name="LogNewValue", type="text", nullable=true)
     */
    private $logNewValue;

    /**
     * @var string
     *
     * @ORM\Column(name="LogIP", type="string", nullable=true, length=255)
     */
    private $logIP;

    /**
     * Log constructor.
     */
    public function __construct()
    {
        $this->logIP = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
    }

    /**
     * @ORM\PrePersist()
     */
    public function initDate()
    {
        $this->logDateTime = new \DateTime();
    }

    /**
     * Get logID
     *
     * @return integer
     */
    public function getLogID()
    {
        return $this->logID;
    }

    /**
     * Set logDateTime
     *
     * @param \DateTime $logDateTime
     *
     * @return Log
     */
    public function setLogDateTime($logDateTime)
    {
        $this->logDateTime = $logDateTime;

        return $this;
    }

    /**
     * Get logDateTime
     *
     * @return \DateTime
     */
    public function getLogDateTime()
    {
        return $this->logDateTime;
    }

    /**
     * Set logEmail
     *
     * @param string $logEmail
     *
     * @return Log
     */
    public function setLogEmail($logEmail)
    {
        $this->logEmail = $logEmail;

        return $this;
    }

    /**
     * Get logEmail
     *
     * @return string
     */
    public function getLogEmail()
    {
        return $this->logEmail;
    }

    /**
     * Set logTable
     *
     * @param string $logTable
     *
     * @return Log
     */
    public function setLogTable($logTable)
    {
        $this->logTable = $logTable;

        return $this;
    }

    /**
     * Get logTable
     *
     * @return string
     */
    public function getLogTable()
    {
        return $this->logTable;
    }

    /**
     * Set logField
     *
     * @param string $logField
     *
     * @return Log
     */
    public function setLogField($logField)
    {
        $this->logField = $logField;

        return $this;
    }

    /**
     * Get logField
     *
     * @return string
     */
    public function getLogField()
    {
        return $this->logField;
    }

    /**
     * Set logOldValue
     *
     * @param string $logOldValue
     *
     * @return Log
     */
    public function setLogOldValue($logOldValue)
    {
        $this->logOldValue = $logOldValue;

        return $this;
    }

    /**
     * Get logOldValue
     *
     * @return string
     */
    public function getLogOldValue()
    {
        return $this->logOldValue;
    }

    /**
     * Set logNewValue
     *
     * @param string $logNewValue
     *
     * @return Log
     */
    public function setLogNewValue($logNewValue)
    {
        $this->logNewValue = $logNewValue;

        return $this;
    }

    /**
     * Get logNewValue
     *
     * @return string
     */
    public function getLogNewValue()
    {
        return $this->logNewValue;
    }

    /**
     * Set logIP
     *
     * @param string $logIP
     *
     * @return Log
     */
    public function setLogIP($logIP)
    {
        $this->logIP = $logIP;

        return $this;
    }

    /**
     * Get logIP
     *
     * @return string
     */
    public function getLogIP()
    {
        return $this->logIP;
    }
}

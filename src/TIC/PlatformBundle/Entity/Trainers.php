<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Trainers
 *
 * @ORM\Table(name="Trainers")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\TrainersRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Trainers
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
     * @Assert\NotBlank(message="Lastname is required")
     * @ORM\Column(name="TrainerLastname", type="string", length=255)
     */
    private $trainerLastname;

    /**
     * @var string
     * @Assert\NotBlank(message="Firstname is required")
     * @ORM\Column(name="TrainerFirstname", type="string", length=255)
     */
    private $trainerFirstname;

    /**
     * @var string
     *
     * @ORM\Column(name="TrainerGSM", type="string", length=255, nullable=true)
     */
    private $trainerGSM;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="Birthdate is required")
     * @ORM\Column(name="TrainerBirthdate", type="date", nullable=true)
     */
    private $trainerBirthdate;

    /**
     * @var string
     * @Assert\NotBlank(message="Identity Card Number is required")
     * @ORM\Column(name="TrainerIdentityCardNumber", type="string", length=255, nullable=true)
     */
    private $trainerIdentityCardNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="TrainerIdentityCardValidity", type="string", nullable=true, length=255)
     */
    private $trainerIdentityCardValidity;

    /**
     * @var string
     * @Assert\NotBlank(message="Trainer Nationality is required")
     * @ORM\Column(name="TrainerNationality", type="string", length=255, nullable=true)
     */
    private $trainerNationality;

    /**
     * @var string
     *
     * @ORM\Column(name="TrainerNumberPlate", type="string", length=255, nullable=true)
     */
    private $trainerNumberPlate;

    /**
     * @var string
     *
     * @ORM\Column(name="TrainerCarColor", type="string", length=255, nullable=true)
     */
    private $trainerCarColor;

    /**
     * @var string
     *
     * @ORM\Column(name="TrainerCarModel", type="string", length=255, nullable=true)
     */
    private $trainerCarModel;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(name="TrainerBstormMail", type="string", length=255, nullable=false)
     */
    private $trainerBstormMail;

    /**
     * @var string
     *
     * @ORM\Column(name="TrainerClientMail", type="string", length=255, nullable=true)
     */
    private $trainerClientMail;

    /**
     * @var string
     * @ORM\Column(name="TrainerPersonalMail", type="string", length=255, nullable=true)
     */
    private $trainerPersonalMail;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="First day of the trainer is required")
     * @ORM\Column(name="TrainerFirstDay", type="date", nullable=true)
     */
    private $trainerFirstDay;

    /**
     * @var boolean
     *
     * @ORM\Column(name="TrainerSelfEmployed", type="boolean")
     */
    private $trainerSelfEmployed;

    /**
     * @var string
     *
     * @ORM\Column(name="TrainerTVANumber", type="string", length=255, nullable=true)
     */
    private $trainerTVANumber;

    /**
     * @var float
     *
     * @ORM\Column(name="TrainerDayCost", type="float", nullable=true)
     */
    private $trainerDayCost;

    /**
     * @var float
     *
     * @ORM\Column(name="TrainerKilometreRates", type="float", nullable=true)
     */
    private $trainerKilometreRates;

    /**
     * @var string
     *
     * @ORM\Column(name="TrainerCalendarID", type="string", nullable=true, length=255)
     */
    private $trainerCalendarID;

    /**
     * @var boolean
     *
     * @ORM\Column(name="TrainerActive", type="boolean", nullable=false)
     */
    private $trainerActive;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="TrainerColor", type="string", nullable=true, length=255)
     */
    private $trainerColor;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="TrainerTextColor", type="string", nullable=true, length=255)
     */
    private $trainerTextColor;

    /**
     * @ORM\OneToOne(targetEntity="TIC\PlatformBundle\Entity\Addresses", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="AddressID")
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity="Languages", inversedBy="trainers")
     * @ORM\JoinTable(name="TrainersLanguages",
     *      joinColumns={@ORM\JoinColumn(name="TrainerID", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="LanguageID", referencedColumnName="id")}
     * )
     */
    private $languages;

    /**
     * @ORM\ManyToOne(targetEntity="TIC\PlatformBundle\Entity\Countries", inversedBy="trainers")
     * @ORM\JoinColumn(name="CountryID" ,  nullable=true)
     */
    private $Country;

    /**
     * @ORM\ManyToOne(targetEntity="Employer", inversedBy="trainers")
     * @ORM\JoinColumn(name="EmployerID", referencedColumnName="EmployerID", nullable=true)
     */
    private $employer;

    /**
     * @ORM\ManyToMany(targetEntity="TIC\PlatformBundle\Entity\Sessions", mappedBy="trainer")
     */
    private $sessions;

    /**
     * @var Document
     * @Assert\Valid()
     *
     * @ORM\OneToMany(targetEntity="Document", mappedBy="trainer", cascade={"persist", "remove"})
     */
    private $documentsIdentityCard;

    /**
     * @var Document
     * @Assert\Valid()
     *
     * @ORM\ManyToOne(targetEntity="Document", cascade={"persist", "remove"}, inversedBy="trainerCV")
     * @ORM\JoinColumn(name="DocumentCVID", referencedColumnName="DocumentID", nullable=true)
     */
    private $documentCv;

    /**
     * @ORM\OneToMany(targetEntity="TIC\PlatformBundle\Entity\events", mappedBy="trainer")
     */
    private $events;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTrainerFirstname() . " " . $this->getTrainerLastname();
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->sessions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->languages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->documentsIdentityCard = new \Doctrine\Common\Collections\ArrayCollection();
        $this->trainerActive = true;
        $this->trainerColor = "#FFFFFF";
        $this->trainerTextColor = "#0E64A0";
    }

    public function updateFiles($path, EntityManager $em)
    {
        if ($this->documentCv !== null) {
            if ($this->documentCv->getFile() !== null || $this->documentCv->getDocumentID() !== null) {
                $this->documentCv->setInfoUpload($path, 'CV');
            } else {
                $this->documentCv = null;
            }
        }
        if ($this->documentsIdentityCard->get('file')[0] !== null){
            $files = $this->documentsIdentityCard->get('file');
            foreach ($this->documentsIdentityCard->toArray() as $elem) {
                if ($elem instanceof Document) {
                    $this->removeDocumentsIdentityCard($elem);
                    $elem->setInfoUpload($path, 'ID');
                    $em->remove($elem);
                }
            }
            $this->documentsIdentityCard->clear();
            foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                    $document = new Document();
                    $document->setFile($file);
                    $document->setInfoUpload($path, 'ID');
                    $this->addDocumentsIdentityCard($document);
                    $document->setTrainer($this);
                }
            }
        } else {
            $this->documentsIdentityCard->remove('file');
        }
    }

    public function prepareForRemoveFiles($path)
    {
        if ($this->documentCv !== null) {
            $this->documentCv->setInfoUpload($path, 'CV');
        }

        if (count($this->documentsIdentityCard) > 0) {
            foreach ($this->documentsIdentityCard->toArray() as $elem) {
                if ($elem instanceof Document)
                {
                    $elem->setInfoUpload($path, 'ID');
                }
            }
        }
    }

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
     * Set trainerLastname
     *
     * @param string $trainerLastname
     * @return Trainers
     */
    public function setTrainerLastname($trainerLastname)
    {
        $this->trainerLastname = $trainerLastname;

        return $this;
    }

    /**
     * Get trainerLastname
     *
     * @return string
     */
    public function getTrainerLastname()
    {
        return $this->trainerLastname;
    }

    /**
     * Set trainerFirstname
     *
     * @param string $trainerFirstname
     * @return Trainers
     */
    public function setTrainerFirstname($trainerFirstname)
    {
        $this->trainerFirstname = $trainerFirstname;

        return $this;
    }

    /**
     * Get trainerFirstname
     *
     * @return string
     */
    public function getTrainerFirstname()
    {
        return $this->trainerFirstname;
    }

    /**
     * Set trainerGSM
     *
     * @param string $trainerGSM
     * @return Trainers
     */
    public function setTrainerGSM($trainerGSM)
    {
        $this->trainerGSM = $trainerGSM;

        return $this;
    }

    /**
     * Get trainerGSM
     *
     * @return string
     */
    public function getTrainerGSM()
    {
        return $this->trainerGSM;
    }

    /**
     * Set trainerBirthdate
     *
     * @param \DateTime $trainerBirthdate
     * @return Trainers
     */
    public function setTrainerBirthdate($trainerBirthdate)
    {
        $this->trainerBirthdate = $trainerBirthdate;

        return $this;
    }

    /**
     * Get trainerBirthdate
     *
     * @return \DateTime
     */
    public function getTrainerBirthdate()
    {
        return $this->trainerBirthdate;
    }

    /**
     * Set trainerIdentityCardNumber
     *
     * @param string $trainerIdentityCardNumber
     * @return Trainers
     */
    public function setTrainerIdentityCardNumber($trainerIdentityCardNumber)
    {
        $this->trainerIdentityCardNumber = $trainerIdentityCardNumber;

        return $this;
    }

    /**
     * Get trainerIdentityCardNumber
     *
     * @return string
     */
    public function getTrainerIdentityCardNumber()
    {
        return $this->trainerIdentityCardNumber;
    }

    /**
     * Set trainerNationality
     *
     * @param string $trainerNationality
     * @return Trainers
     */
    public function setTrainerNationality($trainerNationality)
    {
        $this->trainerNationality = $trainerNationality;

        return $this;
    }

    /**
     * Get trainerNationality
     *
     * @return string
     */
    public function getTrainerNationality()
    {
        return $this->trainerNationality;
    }

    /**
     * Set trainerNumberPlate
     *
     * @param string $trainerNumberPlate
     * @return Trainers
     */
    public function setTrainerNumberPlate($trainerNumberPlate)
    {
        $this->trainerNumberPlate = $trainerNumberPlate;

        return $this;
    }

    /**
     * Get trainerNumberPlate
     *
     * @return string
     */
    public function getTrainerNumberPlate()
    {
        return $this->trainerNumberPlate;
    }

    /**
     * Set trainerCarColor
     *
     * @param string $trainerCarColor
     * @return Trainers
     */
    public function setTrainerCarColor($trainerCarColor)
    {
        $this->trainerCarColor = $trainerCarColor;

        return $this;
    }

    /**
     * Get trainerCarColor
     *
     * @return string
     */
    public function getTrainerCarColor()
    {
        return $this->trainerCarColor;
    }

    /**
     * Set trainerCarModel
     *
     * @param string $trainerCarModel
     * @return Trainers
     */
    public function setTrainerCarModel($trainerCarModel)
    {
        $this->trainerCarModel = $trainerCarModel;

        return $this;
    }

    /**
     * Get trainerCarModel
     *
     * @return string
     */
    public function getTrainerCarModel()
    {
        return $this->trainerCarModel;
    }

    /**
     * Set trainerBstormMail
     *
     * @param string $trainerBstormMail
     * @return Trainers
     */
    public function setTrainerBstormMail($trainerBstormMail)
    {
        $this->trainerBstormMail = $trainerBstormMail;

        return $this;
    }

    /**
     * Get trainerBstormMail
     *
     * @return string
     */
    public function getTrainerBstormMail()
    {
        return $this->trainerBstormMail;
    }

    /**
     * Set trainerClientMail
     *
     * @param string $trainerClientMail
     * @return Trainers
     */
    public function setTrainerClientMail($trainerClientMail)
    {
        $this->trainerClientMail = $trainerClientMail;

        return $this;
    }

    /**
     * Get trainerClientMail
     *
     * @return string
     */
    public function getTrainerClientMail()
    {
        return $this->trainerClientMail;
    }

    /**
     * Set trainerPersonalMail
     *
     * @param string $trainerPersonalMail
     * @return Trainers
     */
    public function setTrainerPersonalMail($trainerPersonalMail)
    {
        $this->trainerPersonalMail = $trainerPersonalMail;

        return $this;
    }

    /**
     * Get trainerPersonalMail
     *
     * @return string
     */
    public function getTrainerPersonalMail()
    {
        return $this->trainerPersonalMail;
    }

    /**
     * Set trainerFirstDay
     *
     * @param \DateTime $trainerFirstDay
     * @return Trainers
     */
    public function setTrainerFirstDay($trainerFirstDay)
    {
        $this->trainerFirstDay = $trainerFirstDay;

        return $this;
    }

    /**
     * Get trainerFirstDay
     *
     * @return \DateTime
     */
    public function getTrainerFirstDay()
    {
        return $this->trainerFirstDay;
    }

    /**
     * Set trainerSelfEmployed
     *
     * @param boolean $trainerSelfEmployed
     * @return Trainers
     */
    public function setTrainerSelfEmployed($trainerSelfEmployed)
    {
        $this->trainerSelfEmployed = $trainerSelfEmployed;

        return $this;
    }

    /**
     * Get trainerSelfEmployed
     *
     * @return boolean
     */
    public function getTrainerSelfEmployed()
    {
        return $this->trainerSelfEmployed;
    }

    /**
     * Set trainerTVANumber
     *
     * @param string $trainerTVANumber
     * @return Trainers
     */
    public function setTrainerTVANumber($trainerTVANumber)
    {
        $this->trainerTVANumber = $trainerTVANumber;

        return $this;
    }

    /**
     * Get trainerTVANumber
     *
     * @return string
     */
    public function getTrainerTVANumber()
    {
        return $this->trainerTVANumber;
    }

    /**
     * Set trainerDayCost
     *
     * @param float $trainerDayCost
     * @return Trainers
     */
    public function setTrainerDayCost($trainerDayCost)
    {
        $this->trainerDayCost = $trainerDayCost;

        return $this;
    }

    /**
     * Get trainerDayCost
     *
     * @return float
     */
    public function getTrainerDayCost()
    {
        return $this->trainerDayCost;
    }

    /**
     * Set Country
     *
     * @param \TIC\PlatformBundle\Entity\Countries $country
     * @return Trainers
     */
    public function setCountry(\TIC\PlatformBundle\Entity\Countries $country = null)
    {
        $this->Country = $country;

        return $this;
    }

    /**
     * Get Country
     *
     * @return \TIC\PlatformBundle\Entity\Country
     */
    public function getCountry()
    {
        return $this->Country;
    }

    /**
     * Set address
     *
     * @param \TIC\PlatformBundle\Entity\Addresses $address
     * @return Trainers
     */
    public function setAddress(\TIC\PlatformBundle\Entity\Addresses $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \TIC\PlatformBundle\Entity\Addresses
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set trainerKilometreRates
     *
     * @param float $trainerKilometreRates
     * @return Trainers
     */
    public function setTrainerKilometreRates($trainerKilometreRates)
    {
        $this->trainerKilometreRates = $trainerKilometreRates;

        return $this;
    }

    /**
     * Get trainerKilometreRates
     *
     * @return float
     */
    public function getTrainerKilometreRates()
    {
        return $this->trainerKilometreRates;
    }

    /**
     * Set trainerCalendarID
     *
     * @param string $trainerCalendarID
     * @return Trainers
     */
    public function setTrainerCalendarID($trainerCalendarID)
    {
        $this->trainerCalendarID = $trainerCalendarID;

        return $this;
    }

    /**
     * Get trainerCalendarID
     *
     * @return string 
     */
    public function getTrainerCalendarID()
    {
        return $this->trainerCalendarID;
    }

    /**
     * Set employer
     *
     * @param \TIC\PlatformBundle\Entity\Employer $employer
     * @return Trainers
     */
    public function setEmployer(\TIC\PlatformBundle\Entity\Employer $employer = null)
    {
        $this->employer = $employer;

        return $this;
    }

    /**
     * Get employer
     *
     * @return \TIC\PlatformBundle\Entity\Employer 
     */
    public function getEmployer()
    {
        return $this->employer;
    }

    /**
     * Add sessions
     *
     * @param \TIC\PlatformBundle\Entity\Sessions $sessions
     * @return Trainers
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
     * Set trainerActive
     *
     * @param boolean $trainerActive
     * @return Trainers
     */
    public function setTrainerActive($trainerActive)
    {
        $this->trainerActive = $trainerActive;

        return $this;
    }

    /**
     * Get trainerActive
     *
     * @return boolean 
     */
    public function getTrainerActive()
    {
        return $this->trainerActive;
    }

    /**
     * Set trainerColor
     *
     * @param string $trainerColor
     * @return Trainers
     */
    public function setTrainerColor($trainerColor)
    {
        $this->trainerColor = $trainerColor;

        return $this;
    }

    /**
     * Get trainerColor
     *
     * @return string 
     */
    public function getTrainerColor()
    {
        return $this->trainerColor;
    }

    /**
     * Set trainerTextColor
     *
     * @param string $trainerTextColor
     * @return Trainers
     */
    public function setTrainerTextColor($trainerTextColor)
    {
        $this->trainerTextColor = $trainerTextColor;

        return $this;
    }

    /**
     * Get trainerTextColor
     *
     * @return string 
     */
    public function getTrainerTextColor()
    {
        return $this->trainerTextColor;
    }

    /**
     * Add languages
     *
     * @param \TIC\PlatformBundle\Entity\Languages $languages
     * @return Trainers
     */
    public function addLanguage(\TIC\PlatformBundle\Entity\Languages $languages)
    {
        $this->languages[] = $languages;

        return $this;
    }

    /**
     * Remove languages
     *
     * @param \TIC\PlatformBundle\Entity\Languages $languages
     */
    public function removeLanguage(\TIC\PlatformBundle\Entity\Languages $languages)
    {
        $this->languages->removeElement($languages);
    }

    /**
     * Get languages
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * Set trainerIdentityCardValidity
     *
     * @param string $trainerIdentityCardValidity
     * @return Trainers
     */
    public function setTrainerIdentityCardValidity($trainerIdentityCardValidity)
    {
        $this->trainerIdentityCardValidity = $trainerIdentityCardValidity;

        return $this;
    }

    /**
     * Get trainerIdentityCardValidity
     *
     * @return string 
     */
    public function getTrainerIdentityCardValidity()
    {
        return $this->trainerIdentityCardValidity;
    }
    
    /**
     * Set documentCv
     *
     * @param \TIC\PlatformBundle\Entity\Document $documentCv
     * @return Trainers
     */
    public function setDocumentCv(\TIC\PlatformBundle\Entity\Document $documentCv = null)
    {
        $this->documentCv = $documentCv;

        return $this;
    }

    /**
     * Get documentCv
     *
     * @return \TIC\PlatformBundle\Entity\Document 
     */
    public function getDocumentCv()
    {
        return $this->documentCv;
    }

    /**
     * Add documentsIdentityCard
     *
     * @param \TIC\PlatformBundle\Entity\Document $documentsIdentityCard
     * @return Trainers
     */
    public function addDocumentsIdentityCard(\TIC\PlatformBundle\Entity\Document $documentsIdentityCard)
    {
        $this->documentsIdentityCard[] = $documentsIdentityCard;

        return $this;
    }

    /**
     * Remove documentsIdentityCard
     *
     * @param \TIC\PlatformBundle\Entity\Document $documentsIdentityCard
     */
    public function removeDocumentsIdentityCard(\TIC\PlatformBundle\Entity\Document $documentsIdentityCard)
    {
        $this->documentsIdentityCard->removeElement($documentsIdentityCard);
    }

    /**
     * Get documentsIdentityCard
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDocumentsIdentityCard()
    {
        return $this->documentsIdentityCard;
    }

    /**
     * Add events
     *
     * @param \TIC\PlatformBundle\Entity\events $events
     * @return Trainers
     */
    public function addEvent(\TIC\PlatformBundle\Entity\events $events)
    {
        $this->events[] = $events;

        return $this;
    }

    /**
     * Remove events
     *
     * @param \TIC\PlatformBundle\Entity\events $events
     */
    public function removeEvent(\TIC\PlatformBundle\Entity\events $events)
    {
        $this->events->removeElement($events);
    }

    /**
     * Get events
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEvents()
    {
        return $this->events;
    }
}

<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Document
 *
 * @ORM\Table(name="Documents")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Repository\DocumentRepository")
 * @UniqueEntity("documentCurrentName")
 * @ORM\HasLifecycleCallbacks()
 */
class Document
{
    /**
     * @var integer
     *
     * @ORM\Column(name="DocumentID", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $documentID;

    /**
     * @var UploadedFile
     * @Assert\File(
     *     maxSize="6M"
     * )
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="DocumentOriginalName", type="string", nullable=false, length=255)
     */
    private $documentOriginalName;

    /**
     * @var string
     *
     * @ORM\Column(name="DocumentCurrentName", type="string", nullable=false, length=255)
     */
    private $documentCurrentName;

    /**
     * @var string
     *
     * @ORM\Column(name="DocumentMimeType", type="string", nullable=true, length=255)
     */
    private $documentMimeType;

    /**
     * @var string
     *
     * @ORM\Column(name="DocumentExtension", type="string", nullable=true, length=255)
     */
    private $documentExtension;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $folder;

    /**
     * @ORM\ManyToOne(targetEntity="Trainers", inversedBy="documentsIdentityCard")
     * @ORM\JoinColumn(name="TrainerID", referencedColumnName="id", nullable=true)
     */
    private $trainer;

    /**
     * @ORM\OneToMany(targetEntity="Trainers", mappedBy="documentCv")
     */
    private $trainerCV;


    public function setInfoUpload($path, $folder)
    {
        $this->path = $path;
        $this->folder = $folder;
    }

    /**
     * @return string
     */
    protected function getPath()
    {
        return join(DIRECTORY_SEPARATOR, array($this->path, $this->folder));
    }

    /**
     * @return string
     */
    public function getAbsolutePath()
    {
        return join(DIRECTORY_SEPARATOR, array($this->getPath(), $this->documentCurrentName));
    }

    /**
     * @ORM\PrePersist()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }

        if ($this->documentCurrentName !== null) {
            $this->removeUpload();
        }

        $this->documentOriginalName = $this->file->getClientOriginalName();
        $this->documentMimeType = $this->file->getMimeType();
        $this->documentExtension = $this->file->getClientOriginalExtension();
        $this->documentCurrentName  = sprintf("%s.%s", md5(sprintf("%s_%s_%s", $this->documentOriginalName, uniqid("", true), md5(mt_rand()))), $this->documentExtension);
        
        $this->getFile()->move(
            $this->getPath(),
            $this->documentCurrentName
        );

        $this->file= null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getAbsolutePath();
        if(file_exists($file))
        {
            unlink($file);
        }
    }

    /**
     * Get documentID
     *
     * @return integer 
     */
    public function getDocumentID()
    {
        return $this->documentID;
    }

    /**
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     * @return Document
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Set documentOriginalName
     *
     * @param string $documentOriginalName
     * @return Document
     */
    public function setDocumentOriginalName($documentOriginalName)
    {
        $this->documentOriginalName = $documentOriginalName;

        return $this;
    }

    /**
     * Get documentOriginalName
     *
     * @return string 
     */
    public function getDocumentOriginalName()
    {
        return $this->documentOriginalName;
    }

    /**
     * Set documentCurrentName
     *
     * @param string $documentCurrentName
     * @return Document
     */
    public function setDocumentCurrentName($documentCurrentName)
    {
        $this->documentCurrentName = $documentCurrentName;

        return $this;
    }

    /**
     * Get documentCurrentName
     *
     * @return string 
     */
    public function getDocumentCurrentName()
    {
        return $this->documentCurrentName;
    }

    /**
     * Set documentMimeType
     *
     * @param string $documentMimeType
     * @return Document
     */
    public function setDocumentMimeType($documentMimeType)
    {
        $this->documentMimeType = $documentMimeType;

        return $this;
    }

    /**
     * Get documentMimeType
     *
     * @return string 
     */
    public function getDocumentMimeType()
    {
        return $this->documentMimeType;
    }

    /**
     * Set documentExtension
     *
     * @param string $documentExtension
     * @return Document
     */
    public function setDocumentExtension($documentExtension)
    {
        $this->documentExtension = $documentExtension;

        return $this;
    }

    /**
     * Get documentExtension
     *
     * @return string 
     */
    public function getDocumentExtension()
    {
        return $this->documentExtension;
    }

    /**
     * Set trainer
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainer
     * @return Document
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
     * Constructor
     */
    public function __construct()
    {
        $this->trainerCV = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add trainerCV
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainerCV
     * @return Document
     */
    public function addTrainerCV(\TIC\PlatformBundle\Entity\Trainers $trainerCV)
    {
        $this->trainerCV[] = $trainerCV;

        return $this;
    }

    /**
     * Remove trainerCV
     *
     * @param \TIC\PlatformBundle\Entity\Trainers $trainerCV
     */
    public function removeTrainerCV(\TIC\PlatformBundle\Entity\Trainers $trainerCV)
    {
        $this->trainerCV->removeElement($trainerCV);
    }

    /**
     * Get trainerCV
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrainerCV()
    {
        return $this->trainerCV;
    }
}

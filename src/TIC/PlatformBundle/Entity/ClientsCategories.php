<?php

namespace TIC\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ClientsCategories
 *
 * @ORM\Table(name="ClientsCategories")
 * @ORM\Entity(repositoryClass="TIC\PlatformBundle\Entity\ClientsCategoriesRepository")
 */
class ClientsCategories
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
     * @ORM\Column(name="ClientCategoryLabel", type="string", length=255)
     */
    private $clientCategoryLabel;

    /**
     * @ORM\OneToMany(targetEntity="Clients", mappedBy="clientCategory")
     */
    private $clients;

    /**
     * @return bool
     */
    public function isDeletable()
    {
        return count($this->clients) == 0;
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
     * Set clientCategoryLabel
     *
     * @param string $clientCategoryLabel
     * @return ClientsCategories
     */
    public function setClientCategoryLabel($clientCategoryLabel)
    {
        $this->clientCategoryLabel = $clientCategoryLabel;

        return $this;
    }

    /**
     * Get clientCategoryLabel
     *
     * @return string 
     */
    public function getClientCategoryLabel()
    {
        return $this->clientCategoryLabel;
    }
}

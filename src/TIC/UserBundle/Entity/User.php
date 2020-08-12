<?php

namespace TIC\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="TIC\UserBundle\Entity\UserRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $username;

    /**
     * @var string
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    protected $email;

    /**
     * @Assert\IsTrue(
     *     message="password.empty"
     * )
     * @return bool
     */
    public function isPasswordValid()
    {
        return $this->plainPassword !== null || $this->password !== null;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function updateRoles()
    {
        if (count($this->roles) == 0) {
            $this->addRole("ROLE_USER");
        }
    }

    public function setInitData($email, $password)
    {
        $this->email = $email;
        $this->username = $email;
        $this->plainPassword = $password;
    }

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function getId()
    {
        return $this->id;
    }
}

<?php
// src/UserBundle/Entity/User.php

namespace UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="image", type="string")
     */
    private $image;

    /**
     * Set image
     *
     * @param string $image
     *
     * @return User
     */
    public function setImage($image)
    {

        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     */
    public function getImage()
    {
        return $this->image;
    }

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->addRole('ROLE_USER');
        $this->setImage('defaultImage.png');
    }
}
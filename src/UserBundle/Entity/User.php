<?php
// src/UserBundle/Entity/User.php

namespace UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="UserBundle\Entity\UserRepository")
 * @ORM\Table(name="fos_user")
 * @ORM\HasLifecycleCallbacks
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
     * Inverse side
     * @ORM\OneToMany(targetEntity="GetRecipeBundle\Entity\Recipe", mappedBy="owner")
     */
    protected $recipes;

    /**
     * @var string
     * @Assert\Image(mimeTypesMessage="Powinieneś wybrać zdjęcie!")
     * @Assert\NotBlank(message="Wybierz plik w formie zdjęcia")
     * @Assert\File(maxSize="6000000")
     * @ORM\Column(name="zdjecie", type="string")
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
        $this->recipes = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
}
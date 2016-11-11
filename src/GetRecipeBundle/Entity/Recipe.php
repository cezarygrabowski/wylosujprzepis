<?php

namespace GetRecipeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Entity\User;
/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="GetRecipeBundle\Entity\RecipeRepository")
 * @UniqueEntity(fields="name", message="Ten przepis już istnieje!")
 * @ORM\HasLifecycleCallbacks
 *
 */
class Recipe
{
    const ACCEPTED = 1;
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
*/
    private $id;

    /**
     * @var string
     * @Assert\Image(mimeTypesMessage="Powinieneś wybrać zdjęcie!")
     * @Assert\NotBlank(message="Wybierz plik w formie zdjęcia")
     * @Assert\File(maxSize="6000000")
     * @ORM\Column(name="zdjecie", type="string")
     */
    private $image;

    /**
     * @var string
     * @Assert\NotBlank(message="Uzupełnij nazwę dania.")
     * @Assert\Length(min=5,
     *      max=30,
     *      minMessage="Nazwa powinna się składać z minimum 5 znaków.",
     *      maxMessage="Nazwa za długa! Dozwolone 30 znaków.")
     * @ORM\Column(name="name", type="string", length=255)
     */
     private $name;

    /**
     * @var array
     * @Assert\NotBlank(message="Wybierz minimum jeden składnik.
     *      Jeśli go nie widzisz, kliknij opcję: Nie widzę tu moich składników")
     * @ORM\Column(name="components", type="simple_array")
     */
    private $components;

    /**
     * @var int
     * @Assert\NotNull(message="Wybierz coś")
     * @ORM\Column(name="time", type="integer")
     */
    private $time;

    /**
     * @var string
     * @Assert\NotBlank(message="Podaj składniki, ich ilości oraz sposób przygotowania.")
     * @Assert\Length(min=30,
     *      max=2500,
     *      minMessage="Na pewno o niczym nie zapomniałeś? Twój przepis jest za krótki(minimum to 30 znaków).",
     *      maxMessage="Trochę się rozpisałeś. Musisz się zmieścić w 2500 znakach!")
     * @ORM\Column(name="preparation", type="text")
     */
    private $preparation;


    /**
     * @var bool
     *
     * @ORM\Column(name="accepted", type="boolean")
     */
    private $accepted = false;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;


    /**
     * Inverse side
     * @ORM\ManyToOne(
     *     targetEntity="UserBundle\Entity\User",
     *     inversedBy="recipes"
     * )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $owner;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Recipe
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

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set components
     *
     * @param string $components
     *
     * @return Recipe
     */
    public function setComponents($components)
    {
        $this->components = $components;

        return $this;
    }

    /**
     * Get components
     *
     * @return string
     */
    public function getComponents()
    {
        return $this->components;
    }

    /**
     * Set time
     *
     * @param integer $time
     *
     * @return Recipe
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return int
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set preparation
     *
     * @param string $preparation
     *
     * @return Recipe
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;

        return $this;
    }

    /**
     * Get preparation
     *
     * @return string
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * Set accepted
     *
     * @param boolean $accepted
     *
     * @return Recipe
     */
    public function setAccepted($accepted)
    {
        $this->accepted = $accepted;

        return $this;
    }

    /**
     * Get accepted
     *
     * @return bool
     */
    public function getAccepted()
    {
        return $this->accepted;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Recipe
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }
}


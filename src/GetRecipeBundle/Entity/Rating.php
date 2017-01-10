<?php
/**
 * Created by PhpStorm.
 * User: czaro
 * Date: 26.12.16
 * Time: 17:53
 */

namespace GetRecipeBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating")
 * @ORM\Entity(repositoryClass="GetRecipeBundle\Entity\RatingRepository")
 * @ORM\HasLifecycleCallbacks
 *
 */
class Rating
{
    const NOTRATED = 0;


    /**
     * @ORM\Id
     * Inverse side
     * @ORM\ManyToOne(
     *     targetEntity="GetRecipeBundle\Entity\Recipe",
     *     inversedBy="ratings"
     * )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $recipe;

    /**
     * @ORM\Id
     * Inverse side
     * @ORM\ManyToOne(
     *     targetEntity="UserBundle\Entity\User",
     *     inversedBy="votes"
     * )
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $owner;

    /**
    * @ORM\Column(type="float")
    */
    private $rating;

    /**
    * @return mixed
    */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
    * @param mixed $recipe
    */
    public function setRecipe($recipe)
    {
        $this->recipe = $recipe;
    }

    /**
    * @return mixed
    */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
    * @param mixed $owner
    */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
    * @return float
    */
    public function getRating()
    {
        return $this->rating;
    }

    /**
    * @param mixed $rating
    */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }
}
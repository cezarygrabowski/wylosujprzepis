<?php
/**
 * Created by PhpStorm.
 * User: czaro
 * Date: 26.12.16
 * Time: 18:02
 */

namespace GetRecipeBundle\Entity;


use Doctrine\ORM\EntityRepository;

class RatingRepository extends EntityRepository
{
    public function getUsersVoteForRecipe($recipeId, $userId)
    {
        return $this->createQueryBuilder('e')
            ->where('e.owner = :userId')
            ->andWhere('e.recipe = :recipeId')
            ->setParameter(':userId', $userId)
            ->setParameter(':recipeId', $recipeId)
            ->getQuery()
            ->execute();
    }
    public function getRatingOfRecipe($recipeId)
    {
        return $this->createQueryBuilder('e')
            ->where('e.recipe = :recipeId')
            ->setParameter(':recipeId', $recipeId)
            ->getQuery()
            ->execute();
    }

}
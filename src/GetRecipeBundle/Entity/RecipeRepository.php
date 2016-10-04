<?php
/**
 * Created by PhpStorm.
 * User: czarek
 * Date: 2016-09-01
 * Time: 13:16
 */

namespace GetRecipeBundle\Entity;


use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Form;
use Doctrine\Common\Collections\ArrayCollection;
class RecipeRepository extends EntityRepository
{
    /**
     * @param Form $form
     * @return mixed
     */
    public function getRandomRecipe(Form $form)
    {
        $qb = $this->createQueryBuilder('e');

        if($form->getData()->getTime() != 0)
        {
            $qb
                ->andWhere('e.time LIKE :time')
                ->setParameter('time',$form->get('time')->getData());
        }

        $noComponents = false;
        foreach ($form->getData()->getComponents() as $i)
        {
            if($i == 'dowolneskladniki'){
                $noComponents=true;
            }
        }

        if($noComponents==false)
        {
            $qb
                ->andWhere('e.components LIKE :components')
                ->setParameter('components','%'.implode('%', $form->get('components')->getData()).'%');
        }

        $qb
            ->andWhere('e.type LIKE :type')
            ->andWhere('e.accepted = 1')
            ->setParameter('type', $form->getData()->getType());
        $qbTemp = $qb;

        $results = $qbTemp->getQuery()->getResult();
        $numberOfResults = count($results);

        return $qb
            ->setFirstResult(rand(0, $numberOfResults - 1))
            ->setMaxResults(1)
            ->getQuery()
            ->execute();
    }
    /**
     * @return Recipe[]
     */
    public function acceptRecipes()
    {
         return $this->createQueryBuilder('e')
            ->where('e.accepted = 0')
            ->getQuery()
            ->execute();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-11-03
 * Time: 21:53
 */

namespace UserBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;


class UserRepository extends EntityRepository
{

    /**
     * @param $username
     * @return User|null
     */
    public function findOneByUsername($username)
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
        ->getOneOrNullResult();
    }


    public function getIdsOfAllUsers()
    {
        $result =$this->createQueryBuilder('e')
            ->select('e.id')
            ->where('e.enabled = 1')
            ->getQuery()
            ->getScalarResult();

        //http://stackoverflow.com/questions/11657835/how-to-get-a-one-dimensional-scalar-array-as-a-doctrine-dql-query-result
        return array_map('current', $result);
    }
}
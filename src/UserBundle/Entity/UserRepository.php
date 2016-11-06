<?php
/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-11-03
 * Time: 21:53
 */

namespace UserBundle\Entity;

use Doctrine\ORM\EntityRepository;



class UserRepository extends EntityRepository
{

    /**
     * @param $username
     * @return User|null
     */
    public function findOneByUsernameOrEmail($username)
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->where('e.username = :username OR e.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
        ->getOneOrNullResult();
    }

}
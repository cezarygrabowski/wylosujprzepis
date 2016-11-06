<?php
/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-11-03
 * Time: 21:38
 */

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use UserBundle\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadRecipes implements FixtureInterface, OrderedFixtureInterface
{


    public function load(ObjectManager $manager)
    {
        $Czaro = new User();
        $Czaro->setUsername("Czaro");
        $Czaro->setPlainPassword("czaro");
        $Czaro->setEmail("czaros45@gmail.com");
        $manager->persist($Czaro);

        $admin = new User();
        $admin->setUsername("Admin");
        $admin->setEmail("czarodziejskasymfonia@gmail.com");
        $admin->setPlainPassword("nimdA");
        $admin->setRoles(array('ROLE_ADMIN'));
        $manager->persist($admin);

        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
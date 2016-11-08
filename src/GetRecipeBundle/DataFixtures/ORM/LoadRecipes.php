<?php
/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-11-03
 * Time: 21:27
 */

namespace GetRecipeBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use GetRecipeBundle\Entity\Recipe;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;

class LoadRecipes implements FixtureInterface, OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {

        $Czaro = $manager->getRepository('UserBundle:User')
        ->findOneByUsername('Czaro');

        $recipe1 = new Recipe();

        $recipe1->setAuthor($Czaro->getUsername());
        $recipe1->setType('dessert');
        $recipe1->setTime('30');
        $recipe1->setName('Nutella');
        $recipe1->setOwner($Czaro);
        $recipe1->setImage('Recipe1.png');
        $recipe1->setComponents(array('banan, truskawki, miod'));
        $recipe1->setPreparation('Lorem ipsum dolor sit amet magna. Quisque nec turpis et odio. \n
        Morbi ligula accumsan eget, lacinia accumsan adipiscing, risus dolor sit amet, consectetuer dolor placerat nisl ac nunc.\n
         Sed eu viverra semper aliquam id, libero. Integer eu nunc interdum dapibus non, arcu. In ultricies iaculis at\n
         , egestas quis, justo. Sed pharetra. ');
        $manager->persist($recipe1);


        $recipe2= new Recipe();
        $recipe2->setAuthor($Czaro->getUsername());
        $recipe2->setType('breakfast');
        $recipe2->setTime('90');
        $recipe2->setName('Burgery');
        $recipe2->setOwner($Czaro);
        $recipe2->setImage('Recipe2.png');
        $recipe2->setComponents(array('chleb, mleko, dzem, pomidory'));
        $recipe2->setPreparation('Lorem ipsum dolor sit amet magna. Quisque nec turpis et odio. \n
        Morbi ligula accumsan eget, lacinia accumsan adipiscing, risus dolor sit amet, consectetuer dolor placerat nisl ac nunc.\n
         Sed eu viverra semper aliquam id, libero. Integer eu nunc interdum dapibus non, arcu. In ultricies iaculis at\n
         , egestas quis, justo. Sed pharetra. ');
        $manager->persist($recipe2);


        $recipe3 = new Recipe();
        $recipe3->setAuthor($Czaro->getUsername());
        $recipe3->setType('dinner');
        $recipe3->setTime('60');
        $recipe3->setName('Pizza');
        $recipe3->setOwner($Czaro);
        $recipe3->setImage('Recipe3.jpg');
        $recipe3->setComponents(array('chleb, mleko, dzem, pomidory'));
        $recipe3->setPreparation('Lorem ipsum dolor sit amet magna. Quisque nec turpis et odio. \n
        Morbi ligula accumsan eget, lacinia accumsan adipiscing, risus dolor sit amet, consectetuer dolor placerat nisl ac nunc.\n
         Sed eu viverra semper aliquam id, libero. Integer eu nunc interdum dapibus non, arcu. In ultricies iaculis at\n
         , egestas quis, justo. Sed pharetra. ');
        $manager->persist($recipe3);


        $recipe4 = new Recipe();
        $recipe4->setAuthor($Czaro->getUsername());
        $recipe4->setType('supper');
        $recipe4->setTime('90');
        $recipe4->setName('Sushi');
        $recipe4->setOwner($Czaro);
        $recipe4->setImage('Recipe4.jpg');
        $recipe4->setComponents(array('chleb, mleko, dzem, pomidory'));
        $recipe4->setPreparation('Lorem ipsum dolor sit amet magna. Quisque nec turpis et odio. \n
        Morbi ligula accumsan eget, lacinia accumsan adipiscing, risus dolor sit amet, consectetuer dolor placerat nisl ac nunc.\n
         Sed eu viverra semper aliquam id, libero. Integer eu nunc interdum dapibus non, arcu. In ultricies iaculis at\n
         , egestas quis, justo. Sed pharetra. ');

        $manager->persist($recipe4);

        $manager->flush();


    }

    public function getOrder()
    {
        return 20;
    }
}
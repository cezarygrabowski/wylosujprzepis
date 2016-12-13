<?php

/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-11-08
 * Time: 17:16
 */
namespace tests\GetRecipeBundle;

use Doctrine\ORM\EntityManager;
use GetRecipeBundle\Form\UploadRecipeForm;
use Symfony\Component\Form\Test\TypeTestCase;
use UserBundle\Entity\User;
use UserBundle\Entity\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
class UploadRecipeFormTest extends TypeTestCase
{
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ObjectManager $em)
    {
        //parent::__construct();
        $this->em = $em;
    }

    public function testSubmitValidData()
    {
        $client =$this->container->get('doctrine.orm.entity_manager');
        $user = $this->em->getRepository('UserBundle:User')->findOneByUsername('Czaro');
        $formData = array(
            'time' => 30,
            'id' => 133,
            'type' => 'breakfast',
            'owner' => $user,
            'accepted' => 0,
            'name' => 'Test',
            'image' => 'DataFixtures/Recipe1.png',
            'preparation' => 'Lorem ipsum dolor sit amet magna. Quisque nec turpis et odio.',
        );

        $form = $this->factory->create(UploadRecipeForm::class);

        $object = (object)$formData;

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}

<?php

/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-11-08
 * Time: 17:16
 */
namespace tests\GetRecipeBundle;

use GetRecipeBundle\Form\UploadRecipeForm;
use Symfony\Component\Form\Test\TypeTestCase;


class UploadRecipeFormTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'time' => 30,
            'id' => 133,
            'author' => 'czaro',
            'type' => 'breakfast',
            'owner' => 'czaro',
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

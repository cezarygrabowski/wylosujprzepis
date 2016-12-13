<?php
/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-10-30
 * Time: 15:59
 */

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class LogoChanger extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, array(
                'label' => 'Wybierz logo',
                'data_class' => null ,             //http://stackoverflow.com/questions/14423265/symfony-2-form-exception-when-modifying-an-object-that-has-a-filepicture-fie
                'property_path' => 'image'
            ));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' =>'UserBundle\Entity\User',
        ));
    }
}
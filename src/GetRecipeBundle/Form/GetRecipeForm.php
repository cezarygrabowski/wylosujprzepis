<?php
/**
 * Created by PhpStorm.
 * User: czarek
 * Date: 2016-09-05
 * Time: 10:59
 */

namespace GetRecipeBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GetRecipeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time', ChoiceType::class, array(
                'label' => 'Wybierz czas przygotowania:',
                'expanded' =>true,
                'choices'  => array(
                    '1-30min' => 30,
                    '31-60min' => 60,
                    '61-90min' => 90,
                    'dowolny' => 0
                )))
            ->getForm();
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' =>'GetRecipeBundle\Entity\Recipe',
        ));
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: czarek
 * Date: 2016-09-01
 * Time: 15:08
 */

namespace GetRecipeBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
class UploadRecipeForm extends ComponentsForRecipes
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('time', ChoiceType::class, array(
                'label' => 'Wybierz czas przygotowania:',
                'expanded' =>true,
                'data' =>true,
                'choices'  => array(
                    '1-30min' => 30,
                    '31-60min' => 60,
                    '61-90min' => 90,
                )))

            ->add('name', TextType::class,array(
                'label' => 'Wpisz nazwę potrawy'
            ))

            ->add('image', FileType::class, array(
                'label' => 'Wybierz zdjęcie potrawy'
            ))

            ->add('preparation', TextareaType::class, array(
                'label' => 'Wypisz wszystkie składniki oraz sposób przygotowania',
                'attr' => array(
                    'cols' => '50',
                    'rows' => '20'),
            ))

            ->add('author', TextType::class, array(
            ))

            ->add('type', TextType::class,array(
                'mapped' => false,
            ));
            $this->addComponentsAndSetType($builder, $options);

        }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' =>'GetRecipeBundle\Entity\Recipe',
        ));
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-09-22
 * Time: 19:34
 */

namespace GetRecipeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
class ComponentsForRecipes extends AbstractType
{

    protected function addComponentsAndSetType($builder)
    {
        $uri = $_SERVER['REQUEST_URI'];
        if($uri == '/sniadanie' || $uri == '/dodaj-sniadanie')
        {
            $this->addBreakfastComponents($builder);
        }
        else if($uri == '/obiad' || $uri == '/dodaj-obiad')
        {
            $this->addDinnerComponents($builder);
        }
        else if($uri == '/kolacja' || $uri == '/dodaj-kolacje')
        {
            $this->addSupperComponents($builder);
        }
        else if($uri == '/deser' || $uri == '/dodaj-deser')
        {
            $this->addDessertComponents($builder);
        }
    }
    protected function addBreakfastComponents(FormBuilderInterface $builder)
    {
        $builder->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' => true,
            'expanded' => true,
            'choices' => array(
                'Jajka' => 'jajka',
                'Chleb' => 'chleb',
                'Mleko' => 'mleko',
                'dżem' => 'dziem',
                'Biały Ser' => 'bialy ser',
                'Pomidory' => 'pomidory',
                'Łosoś' => 'losos',
                'Tuńczyk' => 'tunczyk',
                'Płatki owsiane' => 'platki owsiane',
            )
        ));
        $builder->getData()->setType('breakfast');
    }

    public function addDinnerComponents(FormBuilderInterface $builder)
    {
        $builder->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' => true,
            'expanded' => true,
            'choices' => array(
                'Wieprzowina' => 'wieprzowina',
                'Wołowina' => 'wolowina',
                'Kurczak' => 'kurczak',
                'Baranina' => 'baranina',
                'Tuńczyk' => 'tunczyk',
                'Łosoś' => 'losos',
                'Ryż' => 'ryz',
                'Ziemniaki' => 'ziemniaki',
                'Makaron' => 'makaron',
                'Kasza gryczana' => 'kasza gryczna',
                'Orzechy' => 'orzechy',
                'Marchew' => 'marchew',
                'Cebula' => 'cebula',
                'Sałata' => 'salata',
                'Nie widzę tu moich składników' => 'brakskladnikow'
            )));
        $builder->getData()->setType('dinner');
    }


    protected function addSupperComponents(FormBuilderInterface $builder)
    {
        $builder->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' => true,
            'expanded' => true,
            'choices' => array(
                'Biały Ser' => 'bialy ser',
                'Tuńczyk' => 'tunczyk',
                'Serek Wiejski' => 'ser wiejski',
                'Cukinia' => 'cukinia',
                'Marchew' => 'marchew',
                'Orzechy' => 'orzechy',
                'Pierś z kurczaka' => 'piers z kurczaka',
                'Dowolne Składniki' => 'dowolneskladniki'
            )));
        $builder->getData()->setType('supper');
    }


    protected function addDessertComponents(FormBuilderInterface $builder)
    {
        $builder->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' => true,
            'expanded' => true,
            'choices' => array(
                'Płatki owsiane' => 'platki owsiane',
                'Banan' => 'banan',
                'Masło orzechowe' => 'maslo orzechowe',
                'Migdały' => 'migdały',
                'Jajka' => 'jajka',
                'Mleko' => 'mleko',
                'Orzechy' => 'orzechy',
                'Jogurt naturalny' => 'jogurt naturalny',
                'Serek mascarpone' => 'serek mascarpone',
                'Truskawki' => 'truskawka',
                'Czekolada gorzka' => 'czekolada gorzka',
                'Miód' => 'miod',
                'Biały Ser' => 'bialyser',
                'Nie widzę tu moich składników' => 'brakskladnikow'
            )));
        $builder->getData()->setType('dessert');
    }
}
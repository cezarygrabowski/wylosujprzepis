<?php

namespace GetRecipeBundle\Controller;

use GetRecipeBundle\Form\RecipeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use GetRecipeBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RecipeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('GetRecipeBundle:Default:index.html.twig');
    }

    /**
     * @Route("/sniadanie", name="sniadanie")
     */
    public function sniadanieAction()
    {
        $recipe = new Recipe();

        $form = $this->createFormBuilder($recipe)
            ->add('time', ChoiceType::class, array(
                'label' => 'Wybierz czas przygotowania:',
                'expanded' =>true,
                'choices'  => array(
                    '1-30min' => '30',
                    '31-60min' => '60',
                    '61-90min' => '90',
                    'Dowolny' => 'dowolny',
                )))
            ->add('components', ChoiceType::class, array(
                'label' => 'Wybierz składniki:',
                'multiple' =>true,
                'expanded' =>true,
                'choices'  => array(
                    'Jajka' => 'jajka',
                    'Chleb' => 'chleb',
                    'Mleko' => 'mleko',
                    'Miód' => 'miod',
                    'Biały Ser' => 'bialy ser',
                    'Pomidory' => 'pomidor',
                    'Łosoś' => 'losos',
                    'Tuńczyk' => 'tunczyk',
                    'Dowolne Składniki' => 'dowolneskladniki'
                )))
            ->add('save', SubmitType::class, array('label' => 'Losuj przepis!'))
            ->getForm();

        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/obiad", name="obiad")
     */
    public function obiadAction()
    {
        $recipe = new Recipe();

        $form = $this->createFormBuilder($recipe)
            ->add('time', ChoiceType::class, array(
                'label' => 'Wybierz czas przygotowania:',
                'expanded' =>true,
                'choices'  => array(
                    '1-30min' => '30',
                    '31-60min' => '60',
                    '61-90min' => '90',
                    'Dowolny' => 'dowolny',
                )))
            ->add('components', ChoiceType::class, array(
                'label' => 'Wybierz składniki:',
                'multiple' =>true,
                'expanded' =>true,
                'choices'  => array(
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
                    'Dowolne Składniki' => 'dowolneskladniki'
                )))
            ->add('save', SubmitType::class, array('label' => 'Losuj przepis!'))
            ->getForm();

        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/kolacja", name="kolacja")
     */
    public function kolacjaAction()
    {
        $recipe = new Recipe();

        $form = $this->createFormBuilder($recipe)
            ->add('time', ChoiceType::class, array(
                'label' => 'Wybierz czas przygotowania:',
                'expanded' =>true,
                'choices'  => array(
                    '1-30min' => '30',
                    '31-60min' => '60',
                    '61-90min' => '90',
                    'Dowolny' => 'dowolny',
                )))
            ->add('components', ChoiceType::class, array(
                'label' => 'Wybierz składniki:',
                'multiple' =>true,
                'expanded' =>true,
                'choices'  => array(
                    'Biały Ser' => 'bialy ser',
                    'Tuńczyk' => 'tunczyk',
                    'Serek Wiejski' => 'ser wiejski',
                    'Cukinia' => 'cukinia',
                    'Marchew' => 'marchew',
                    'Orzechy' => 'orzechy',
                    'Pierś z kurczaka' => 'piers z kurczaka',
                    'Dowolne Składniki' => 'dowolneskladniki'
                )))
            ->add('save', SubmitType::class, array('label' => 'Losuj przepis!'))
            ->getForm();

        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/deser", name="deser")
     */
    public function deserAction()
    {
        $recipe = new Recipe();

        $form = $this->createFormBuilder($recipe)
            ->add('time', ChoiceType::class, array(
                'label' => 'Wybierz czas przygotowania:',
                'expanded' =>true,
                'choices'  => array(
                    '1-30min' => '30',
                    '31-60min' => '60',
                    '61-90min' => '90',
                    'Dowolny' => 'dowolny',
                )))
            ->add('components', ChoiceType::class, array(
                'label' => 'Wybierz składniki:',
                'multiple' =>true,
                'expanded' =>true,
                'choices'  => array(
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
                    'Dowolne Składniki' => 'dowolneskladniki'
                )))
            ->add('save', SubmitType::class, array('label' => 'Losuj przepis!'))
            ->getForm();

        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }



    /**
     * @Route("/dodaj-przepis", name="dodaj_przepis")
     */
    public function dodajPrzepisAction()
    {
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipe.html.twig');
    }

    /**
     * @Route("/dodaj-sniadanie", name="dodaj_sniadanie")
     */
    public function dodajSniadanieAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' =>true,
            'expanded' =>true,
            'mapped' => true,
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

        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if($form->isValid())
            {
                return new Response('Cos tam gitara');
            }
            return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
                'form' => $form->createView()));
        }
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/dodaj-obiad", name="dodaj_obiad")
     */
    public function dodajObiadAction()
    {

        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' =>true,
            'expanded' =>true,
            'choices'  => array(
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

        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/dodaj-kolacje", name="dodaj_kolacje")
     */
    public function dodajKolacjeAction()
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' =>true,
            'expanded' =>true,
            'choices'  => array(
                'Biały Ser' => 'bialy ser',
                'Tuńczyk' => 'tunczyk',
                'Serek Wiejski' => 'ser wiejski',
                'Cukinia' => 'cukinia',
                'Marchew' => 'marchew',
                'Orzechy' => 'orzechy',
                'Pierś z kurczaka' => 'piers z kurczaka',
                'Nie widzę tu moich składników' => 'brakskladnikow'
            )));

        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));


    }

    /**
     * @Route("/dodaj-deser", name="dodaj_deser")
     */
    public function dodajDeserAction()
    {
        $recipe = new Recipe();
        $form = $this->createForm(RecipeType::class, $recipe);

        $form->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' =>true,
            'expanded' =>true,
            'choices'  => array(
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
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/wynik-losowania", name="wynik_losowania")
     */
    public function wynik_losowaniaAction()
    {
        return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig');
    }
}

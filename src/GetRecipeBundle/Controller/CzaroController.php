<?php
/**
 * Created by PhpStorm.
 * User: czarek
 * Date: 2016-09-15
 * Time: 13:59
 */

namespace GetRecipeBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use GetRecipeBundle\Entity\RecipeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
class CzaroController extends Controller
{
    /**
     * @return RecipeRepository
     */
    protected function getRecipeRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('GetRecipeBundle:Recipe');
    }

    protected function handleGetFormAction(Request $request, Form $form)
    {
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            if ($form->get('components')->isValid() && $form->get('time')->isValid()) {

                $randomRecipe = $this->getRecipeRepository()
                    ->getRandomRecipe($form);

                return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig', array(
                    'randomRecipe' => $randomRecipe,

                ));
            }
        }

        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    protected function handleUploadFormAction(Request $request, Form $form)
    {
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST') {

            if ($form->isValid() && $form->isSubmitted()) {

                $recipe = $form->getData();

                /** @var UploadedFile $file */
                $file = $recipe->getImage();

                $fileName = md5(uniqid()).'.'. $file->guessExtension();
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );

                $recipe->setImage($fileName);
                $em = $this->getDoctrine()->getManager();
                $em->persist($recipe);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Dodawanie przebiegło pomyślnie. Przepis oczekuje na akceptacje.');

                $url = $this->generateUrl('home');

                return $this->redirect($url);
            }
        }
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }
    protected function addBreakfastComponents(Form $form)
    {
        $form->add('components', ChoiceType::class, array(
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
                'Dowolne składniki' => 'dowolneskladniki'
            )
        ));
        $form->getData()->setType('breakfast');


    }

    protected function addDinnerComponents(Form $form)
    {
        $form->add('components', ChoiceType::class, array(
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

        $form->getData()->setType('dinner');
    }


    protected function addSupperComponents(Form $form)
    {
        $form->add('components', ChoiceType::class, array(
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
        $form->getData()->setType('supper');
    }


    protected function addDessertComponents(Form $form)
    {
        $form->add('components', ChoiceType::class, array(
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
        $form->getData()->setType('dessert');
    }

    protected function handlePasswordForm(Form $formPassword, Request $request)
    {
        $formPassword->add('password', PasswordType::class, array());
        $formPassword->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            if ($formPassword->get('password')->getData() == 'AOCE2270Sw') {
                return $this->redirect($this->generateUrl('admin_panel'));
            }
        }

        return $this->render('GetRecipeBundle:confirmRecipes:confirmRecipes.html.twig', array(
            'formPassword' => $formPassword->createView()
        ));
    }


    protected function handleAdminPanel(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $recipeToAccept = $this->getRecipeRepository()
            ->acceptRecipes();

        if ($request->query->has('acceptRecipe')) {
            foreach ($recipeToAccept as $recipe) {
                $recipe->setAccepted(1);
                $em->persist($recipe);
                $em->flush();
            }

        }
        return $this->render('GetRecipeBundle:confirmRecipes:adminPanel.html.twig', array(
            'recipeToAccept' => $recipeToAccept,
        ));
    }
}
<?php

namespace GetRecipeBundle\Controller;

use GetRecipeBundle\Form\ComponentsForRecipes;
use GetRecipeBundle\Form\GetRecipeForm;
use GetRecipeBundle\Form\UploadRecipeForm;
use Symfony\Component\HttpFoundation\Request;
use GetRecipeBundle\Entity\Recipe;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RecipeController extends CzaroController
{

    /**
     * @Route("/", name="home")
     */

    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $this->render('GetRecipeBundle:Default:index.html.twig', array(
                'user' => $this->getUser()
            ));
        }
        return $this->render('GetRecipeBundle:Default:index.html.twig');

    }

    /**
     * @Route("/sniadanie", name="draw_breakfast")
     */

    public function addBreakfastRecipeAction(Request $request)
    {
        $form = $this->createForm(GetRecipeForm::class, new Recipe(), array('label' => 'breakfast'));

        return $this->handleGetFormAction($request, $form);
    }

    /**
     * @Route("/obiad", name="draw_dinner")
     */
    public function addDinnerRecipeAction(Request $request)
    {
        $form = $this->createForm(GetRecipeForm::class, new Recipe(), array('label' => 'dinner'));

        return $this->handleGetFormAction($request, $form);
    }

    /**
     * @Route("/kolacja", name="draw_supper")
     */
    public function addSupperRecipeAction(Request $request)
    {
        $form = $this->createForm(GetRecipeForm::class, new Recipe(), array('label' => 'supper'));

        return $this->handleGetFormAction($request, $form);
    }

    /**
     * @Route("/deser", name="draw_dessert")
     */
    public function getDessertRecipeAction(Request $request)
    {
        $form = $this->createForm(GetRecipeForm::class, new Recipe(), array('label' => 'dessert'));

        return $this->handleGetFormAction($request, $form);
    }


    /**
     * @Route("/dodaj-przepis", name="add_recipe")
     */
    public function addRecipeAction()
    {
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipe.html.twig');
    }

    /**
     * @Route("/dodaj-sniadanie", name="add_breakfast")
     */
    public function addBreakfastAction(Request $request)
    {

        $form = $this->createForm(UploadRecipeForm::class, new Recipe(), array('label' => 'breakfast'));


        return $this->handleUploadFormAction($request, $form);
    }

    /**
     * @Route("/dodaj-obiad", name="add_dinner")
     */
    public function addDinnerAction(Request $request)
    {
        $form = $this->createForm(UploadRecipeForm::class, new Recipe(), array('label' => 'dinner'));

        return $this->handleUploadFormAction($request, $form);
    }

    /**
     * @Route("/dodaj-kolacje", name="add_supper")
     */
    public function addSupperAction(Request $request)
    {
        $form = $this->createForm(UploadRecipeForm::class, new Recipe(), array('label' => 'supper'));

        return $this->handleUploadFormAction($request, $form);
    }

    /**
     * @Route("/dodaj-deser", name="add_dessert")
     */
    public function addDessertAction(Request $request)
    {
        $form = $this->createForm(UploadRecipeForm::class, new Recipe(), array('label' => 'dessert'));

        return $this->handleUploadFormAction($request, $form);
    }


    /**
     * @Route("/wynik-losowania", name="resultOfDraw")
     */
    public function resultOfaDrawAction()
    {
        return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig');
    }


    /**
     * @Route("/akceptuj-przepisy", name="accept_recipes")
     */
    public function accept_recipesAction(Request $request)
    {
        $formPassword = $this->createFormBuilder()->getForm();
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


    /**
     * @Route("/panel-admina", name="admin_panel")
     */
    public function admin_panelAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $recipeToAccept = $this->getRecipeRepository()
            ->acceptRecipes();

        foreach ($recipeToAccept as $recipe) {
            if ($request->query->has('acceptRecipe'.$recipe->getId())) {
                $recipe->setAccepted(Recipe::ACCEPTED);
                $em->persist($recipe);
                $em->flush();
            }
            else if ($request->query->has('deleteRecipe'.$recipe->getId())) {
                $em->remove($recipe);
                $em->flush();
            }
        }
        return $this->render('GetRecipeBundle:confirmRecipes:adminPanel.html.twig', array(
            'recipeToAccept' => $recipeToAccept,
        ));
    }
}

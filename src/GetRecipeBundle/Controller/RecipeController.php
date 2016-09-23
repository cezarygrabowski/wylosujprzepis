<?php

namespace GetRecipeBundle\Controller;

use GetRecipeBundle\Form\GetRecipeForm;
use GetRecipeBundle\Form\UploadRecipeForm;
use Symfony\Component\HttpFoundation\Request;
use GetRecipeBundle\Entity\Recipe;
use Symfony\Component\Routing\Annotation\Route;
class RecipeController extends CzaroController
{

    /**
     * @Route("/", name="home")
     */

    public function indexAction()
    {
        return $this->render('GetRecipeBundle:Default:index.html.twig');
    }

    /**
     * @Route("/sniadanie", name="draw_breakfast")
     */

    public function addBreakfastRecipeAction(Request $request)
    {

        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe);
        $this->addBreakfastComponents($form);

        return $this->handleGetFormAction($request, $form);
    }

    /**
     * @Route("/obiad", name="draw_dinner")
     */
    public function addDinnerRecipeAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe);
        $this->addDinnerComponents($form);
        return $this->handleGetFormAction($request, $form);
    }

    /**
     * @Route("/kolacja", name="draw_supper")
     */
    public function addSupperRecipeAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe);
        $this->addSupperComponents($form);

        return $this->handleGetFormAction($request, $form);
    }

    /**
     * @Route("/deser", name="draw_dessert")
     */
    public function getDessertRecipeAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe);
        $this->addDessertComponents($form);

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
        $recipe = new Recipe();

        $form = $this->createForm(UploadRecipeForm::class, $recipe);
        $this->addBreakfastComponents($form);

        return $this->handleUploadFormAction($request, $form);
    }

    /**
     * @Route("/dodaj-obiad", name="add_dinner")
     */
    public function addDinnerAction(Request $request)
    {

        $recipe = new Recipe();

        $form = $this->createForm(UploadRecipeForm::class, $recipe);
        $this->addDinnerComponents($form);


        return $this->handleUploadFormAction($request, $form);
    }

    /**
     * @Route("/dodaj-kolacje", name="add_supper")
     */
    public function addSupperAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(UploadRecipeForm::class, $recipe);
        $this->addSupperComponents($form);

        return $this->handleUploadFormAction($request, $form);


    }

    /**
     * @Route("/dodaj-deser", name="add_dessert")
     */
    public function addDessertAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(UploadRecipeForm::class, $recipe);
        $this->addDessertComponents($form);

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
        $this->handlePasswordForm($formPassword, $request);
    }


    /**
     * @Route("/panel-admina", name="admin_panel")
     */
    public function admin_panelAction(Request $request)
    {
        $this->handleAdminPanel($request);
    }
}

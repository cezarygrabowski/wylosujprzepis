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
        return $this->render('GetRecipeBundle:Default:index.html.twig');
    }

    /**
     * @Route("/sniadanie", name="draw_breakfast")
     */

    public function addBreakfastRecipeAction(Request $request)
    {

        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe);

        return $this->handleGetFormAction($request, $form);
    }

    /**
     * @Route("/obiad", name="draw_dinner")
     */
    public function addDinnerRecipeAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe);

        return $this->handleGetFormAction($request, $form);
    }

    /**
     * @Route("/kolacja", name="draw_supper")
     */
    public function addSupperRecipeAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe);

        return $this->handleGetFormAction($request, $form);
    }

    /**
     * @Route("/deser", name="draw_dessert")
     */
    public function getDessertRecipeAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe);

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

        return $this->handleUploadFormAction($request, $form);
    }

    /**
     * @Route("/dodaj-obiad", name="add_dinner")
     */
    public function addDinnerAction(Request $request)
    {

        $recipe = new Recipe();

        $form = $this->createForm(UploadRecipeForm::class, $recipe);

        return $this->handleUploadFormAction($request, $form);
    }

    /**
     * @Route("/dodaj-kolacje", name="add_supper")
     */
    public function addSupperAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(UploadRecipeForm::class, $recipe);

        return $this->handleUploadFormAction($request, $form);


    }

    /**
     * @Route("/dodaj-deser", name="add_dessert")
     */
    public function addDessertAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(UploadRecipeForm::class, $recipe);


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

        if ($request->query->has('acceptRecipe')) {
            foreach ($recipeToAccept as $recipe) {
                $recipe->setAccepted(Recipe::accepted);
                $em->persist($recipe);
                $em->flush();
            }
        }
        else if($request->query->has('deleteRecipe'))
        {
            foreach ($recipeToAccept as $recipe) {
                $em->remove($recipe);
                $em->flush();
            }
        }

        return $this->render('GetRecipeBundle:confirmRecipes:adminPanel.html.twig', array(
            'recipeToAccept' => $recipeToAccept,
        ));
    }
}

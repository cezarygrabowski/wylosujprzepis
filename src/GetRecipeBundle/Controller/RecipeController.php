<?php

namespace GetRecipeBundle\Controller;

use GetRecipeBundle\Entity\Rating;
use GetRecipeBundle\Form\ComponentsForRecipes;
use GetRecipeBundle\Form\GetRecipeForm;
use GetRecipeBundle\Form\UploadRecipeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use GetRecipeBundle\Entity\Recipe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Serializer\Serializer;

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
     * @Route("/panel-admina", name="admin_panel")
     */
    public function admin_panelAction()
    {
        $unacceptedRecipes = $this->getRecipeRepository()->getUnacceptedRecipes();

        return $this->render('GetRecipeBundle:Admin:adminPanel.html.twig', array(
            'unacceptedRecipes' => $unacceptedRecipes,
        ));
    }

    /**
     * @Route("/akceptuj-przepis/{id}", name="accept_recipe")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function acceptRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        if( !(is_object($recipe = $em->getRepository('GetRecipeBundle:Recipe')->find($id)))){
            throw $this->createNotFoundException('Nie mogę znaleźć przepisu...');
        }

        $recipe->setAccepted(Recipe::ACCEPTED);
        $em->persist($recipe);
        $em->flush();

        return $this->redirectToRoute('admin_panel');

    }

    /**
     * @Route("/usun-przepis/{id}", name="remove_recipe")
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function removeRecipeAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        if( !(is_object($recipe = $em->getRepository('GetRecipeBundle:Recipe')->find($id)))){
            throw $this->createNotFoundException('Nie mogę znaleźć przepisu...');
        }

        $em->remove($recipe);
        $em->flush();

        return $this->redirectToRoute('admin_panel');

    }

    public function dealWithRatingAction($recipeId, $givenRating, $format)
    {

        $em = $this->getDoctrine()->getManager();
        if( !(is_object($recipe = $em->getRepository('GetRecipeBundle:Recipe')->find($recipeId)))){
            throw $this->createNotFoundException("Recipe not found, sorry");
        }

        //if user rated this recipe replace old with a new one
        if($rating = $this->getRatingRepository()->getUsersVoteForRecipe($recipeId, $this->getUser()->getId()))
        {
            $rating->setRating($givenRating);
            $em->persist($rating);
        }
        else
        {
            $rating = new Rating();
            $rating->setOwner($this->getUser());
            $rating->setRecipe($recipe);
            $rating->setRating($givenRating);
            $em->persist($rating);
        }
        $em->flush();

        if($format == 'json') {

            $data = array(
                'rated' => true,
            );
            $mergedArrays = array_merge($data, $this->getHistoryOfRecipeRating($recipe));

            $response = new JsonResponse($mergedArrays);
            return $response;
        }
        return null;
    }
}

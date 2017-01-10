<?php

namespace UserBundle\Controller;
use GetRecipeBundle\Entity\RecipeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use GetRecipeBundle\Entity\Recipe;
use GetRecipeBundle\Entity\Rating;
use GetRecipeBundle\Controller\CzaroController as BaseController;
class AdminController extends BaseController
{
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

    /**
     * @Route("/statistics", name="statistics")
     */

    public function statisticsAction()
    {
        $em = $this->getDoctrine()->getManager();

        //number of accepted recipes - type int
        if(!(count($allAcceptedRecipes = $em->getRepository('GetRecipeBundle:Recipe')->getAllAcceptedRecipes()))){ //check if returned array isn't empty
            throw $this->createNotFoundException("There are no recipes uploaded :( ");
        }

        $getBestRatedRecipe = $this->getBestRatedRecipe($allAcceptedRecipes, $em);
        $bestRatedRecipe = $getBestRatedRecipe["bestRatedRecipe"];
        $bestAverageRating = $getBestRatedRecipe["bestAverageRating"];

        $getMostRatedRecipes = $this->getMostRatedRecipes($allAcceptedRecipes, $em);
        $mostRatedRecipes = $getMostRatedRecipes["mostRatedRecipes"];
        $highestNumberOfRatings = $getMostRatedRecipes["highestNumberOfRatings"];

        $getUsersWhoUploadedMostRecipes = $this->getUsersWhoUploadedMostRecipes($em);
        $usersWithMostUploadedRecipes = $getUsersWhoUploadedMostRecipes["usersWithMostUploadedRecipes"];
        $highestNumberOfUploadedRecipes = $getUsersWhoUploadedMostRecipes["highestNumberOfUploadedRecipes"];


        return $this->render("@User/Admin/statistics.html.twig", array(
            'bestRatedRecipe' => $bestRatedRecipe,
            'bestAverageRating' => $bestAverageRating,
            'mostRatedRecipes' => $mostRatedRecipes,
            'highestNumberOfRatings' => $highestNumberOfRatings,
            'usersWithMostUploadedRecipes' => $usersWithMostUploadedRecipes,
            'highestNumberOfUploadedRecipes' => $highestNumberOfUploadedRecipes,
        ));
    }

}

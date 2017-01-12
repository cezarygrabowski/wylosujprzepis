<?php
/**
 * Created by PhpStorm.
 * User: czarek
 * Date: 2016-09-15
 * Time: 13:59
 */

namespace GetRecipeBundle\Controller;


use Doctrine\ORM\EntityManager;
use GetRecipeBundle\Entity\Rating;
use GetRecipeBundle\Entity\RatingRepository;
use GetRecipeBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use GetRecipeBundle\Entity\RecipeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CzaroController extends Controller
{
    /**
     * @return RecipeRepository
     */
    protected function getRecipeRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('GetRecipeBundle:Recipe');
    }
    /**
     * @return RatingRepository
     */
    protected function getRatingRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('GetRecipeBundle:Rating');
    }

    protected function getHistoryOfRecipeRating(Recipe $randomRecipe)
    {
        //check if user rated this recipe
        $givenRating = Rating::NOTRATED;
        $sumOfRating = Rating::NOTRATED;
        $numberOfRatings = Rating::NOTRATED;
        $averageRating = Rating::NOTRATED;


        //if the recipe was rated calculate the average rating and number of ratings
        $allRatingsForRecipe = $this->getRatingRepository()->getRatingOfRecipe($randomRecipe->getId());
        if($allRatingsForRecipe)
        {
            foreach($allRatingsForRecipe as $rating){
                $numberOfRatings++;
                $sumOfRating += $rating->getRating();
            }
        }

        //calculate the average rating
        if($numberOfRatings != 0){
            $averageRating = round(floatval($sumOfRating) / $numberOfRatings, 2);
        }

        //if the user voted for this recipe get his rating, if user is logged in
        if(is_object($this->getUser())){
            if($lastVote = $this->getRatingRepository()->getUsersVoteForRecipe($randomRecipe->getId(), $this->getUser()->getId()))
            {
                $givenRating = $lastVote->getRating();
            }
            return array(
                'randomRecipe' => $randomRecipe,
                'givenRating' => $givenRating,
                'numberOfRatings' => $numberOfRatings,
                'averageRating' => $averageRating
            );
        }
        return array(
            'randomRecipe' => $randomRecipe,
            'numberOfRatings' => $numberOfRatings,
            'averageRating' => $averageRating
        );
    }

    protected function handleGetFormAction(Request $request, Form $form)
    {

        $form->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            if ($form->get('components')->isValid() && $form->get('time')->isValid()) {     //strange things happened here that's why I have 2 arguments in 'IF' statement

                //take random recipe
                if (! is_object($randomRecipe= $this->getRecipeRepository()->getRandomRecipe($form)))
                {
                    $message = 'Niestety nie ma przepisu spełniającego podane parametry.';
                    return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
                        'form' => $form->createView(),
                        'message' => $message
                    ));
                }


                return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig', $this->getHistoryOfRecipeRating($randomRecipe));
            }
        }

        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    protected function handleUploadFormAction(Request $request, Form $form)
    {
        $form->handleRequest($request);
        $recipe = $form->getData();

        if($this->getUser() != null) {
            $recipe->setOwner($this->getUser()->getUsername());
        }
        if ($request->getMethod() == 'POST') {

            if ($form->isValid() && $form->isSubmitted()) {

                $recipe = $form->getData();

                /** @var UploadedFile $file */
                $file = $recipe->getImage();

                $fileName = $this->get('images_uploader')->upload($file);

                $recipe->setImage($fileName);
                $recipe->setOwner($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($recipe);
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'Dodawanie przebiegło pomyślnie. Przepis oczekuje na akceptację.');

                $url = $this->generateUrl('home');

                return $this->redirect($url);
            }
        }
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }
    public function getBestRatedRecipe(array $allAcceptedRecipes, EntityManager $em)
    {
        $bestRatedRecipe = $allAcceptedRecipes[0];
        $sumOfRating = 0;
        $lastBestAverageRating = 0.0;
        //foreach recipe check average rating

        foreach($allAcceptedRecipes as $recipe)
        {
            if(!(count($allRatingsOfRecipe = $em->getRepository('GetRecipeBundle:Rating')->getRatingOfRecipe($recipe->getId())))){
                continue; //continue makes going to the next iteration of the loop
            }

            foreach($allRatingsOfRecipe as $rating)
            {
                $sumOfRating = $rating->getRating();
            }

            $averageRating = floatval($sumOfRating) / count($allRatingsOfRecipe);
            if($averageRating > $lastBestAverageRating)
            {
                $lastBestAverageRating = $averageRating;
                $bestRatedRecipe = $recipe;
            }
        }
        return array(
            'bestRatedRecipe' => $bestRatedRecipe,
            'bestAverageRating' => $lastBestAverageRating
        );
    }
    public function getMostRatedRecipes(array $allAcceptedRecipes, EntityManager $em)
    {
        $mostRatedRecipes = [];
        $highestNumberOfRatings = 0;
        $i=0;

        //get the numberOfRatings of mostRatedRecipe
        foreach($allAcceptedRecipes as $recipe)
        {
            if(!(count($allRatingsOfRecipe = $em->getRepository('GetRecipeBundle:Rating')->getRatingOfRecipe($recipe->getId())))) {
                continue;
            }
            elseif(count($allRatingsOfRecipe) > $highestNumberOfRatings)
            {
                $highestNumberOfRatings = count($allRatingsOfRecipe);
            }
        }
        //get recipes the highest number of ratings
        foreach($allAcceptedRecipes as $recipe)
        {
            if((count($allRatingsOfRecipe = $em->getRepository('GetRecipeBundle:Rating')->getRatingOfRecipe($recipe->getId())))
                == $highestNumberOfRatings)
            {
                $mostRatedRecipes[$i] = $recipe;
                $i++;
            }
        }
        return array(
            'mostRatedRecipes' => $mostRatedRecipes,
            'highestNumberOfRatings' => $highestNumberOfRatings
        );
    }
    public function getUsersWhoUploadedMostRecipes(EntityManager $em)
    {
        $highestNumberOfUploadedRecipes = 0;
        $usersWithMostUploadedRecipes= [];
        $i=0;

        if(!(count($idsOfAllUsers = $em->getRepository('UserBundle:User')->getIdsOfAllUsers()))){
            throw $this->createNotFoundException("No users in database");
        }

        //foreach user check how many recipes he/she uploaded and are accepted
        foreach($idsOfAllUsers as $id)
        {
            if(!(count($allRatingsOfRecipe = $em->getRepository('GetRecipeBundle:Recipe')->getAllAcceptedRecipesOfUser($id)))) {
                continue;
            }
            elseif(count($allRatingsOfRecipe) > $highestNumberOfUploadedRecipes){
                $highestNumberOfUploadedRecipes = count($allRatingsOfRecipe);
            }
        }

        if($highestNumberOfUploadedRecipes == 0){
            throw $this->createNotFoundException("No recipes where uploaded");
        }

        //get users with most uploaded recipes
        foreach($idsOfAllUsers as $id)
        {
            if(count($allRatingsOfRecipe = $em->getRepository('GetRecipeBundle:Recipe')->getAllAcceptedRecipesOfUser($id))
                == $highestNumberOfUploadedRecipes ){
                $usersWithMostUploadedRecipes[$i] = $em -> getRepository('UserBundle:User')->find($id);
                $i++;
            }
        }
        return array(
            'usersWithMostUploadedRecipes' => $usersWithMostUploadedRecipes,
            'highestNumberOfUploadedRecipes' => $highestNumberOfUploadedRecipes,
        );
    }
}
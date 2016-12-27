<?php
/**
 * Created by PhpStorm.
 * User: czarek
 * Date: 2016-09-15
 * Time: 13:59
 */

namespace GetRecipeBundle\Controller;


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

    protected function handleGetFormAction(Request $request, Form $form)
    {

        $form->handleRequest($request);
        if ($request->getMethod() == 'POST') {
            if ($form->get('components')->isValid() && $form->get('time')->isValid()) {     //strange things happened here that's why I have 2 arguments in 'IF' statement
                /**
                 * @var Recipe[]
                 */
                $randomRecipe = $this->getRecipeRepository()
                    ->getRandomRecipe($form);

                if (!$randomRecipe) {
                    $message = 'Niestety nie ma przepisu spełniającego podane parametry.';
                    return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
                        'form' => $form->createView(),
                        'message' => $message
                    ));
                }
                //check if user rated this recipe

                $givenRating = Rating::NOTRATED;
                $sumOfRating = Rating::NOTRATED;
                $numberOfRatings = Rating::NOTRATED;
                $averageRating = Rating::NOTRATED;
                foreach($randomRecipe as $recipe)
                {
                    //if the user voted for this recipe get his rating
                    $ifVoted = $this->getRatingRepository()->getUsersVoteForRecipe($recipe->getId(), $this->getUser()->getId());
                    if($ifVoted)
                    {
                        foreach($ifVoted as $vote){
                            $givenRating = $vote->getRating();
                        }
                    }
                    //if the recipe is rated calculate the average rating and number of ratings
                    $allRatingsForRecipe = $this->getRatingRepository()->getRatingOfRecipe($recipe->getId());
                    if($allRatingsForRecipe){
                        foreach($allRatingsForRecipe as $rating){
                            $numberOfRatings++;
                            $sumOfRating += $rating->getRating();
                        }
                    }
                }

                //calculate the average rating
                if($numberOfRatings != 0){
                    $averageRating = round(floatval($sumOfRating) / $numberOfRatings, 2);
                }

                return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig', array(
                    'randomRecipe' => $randomRecipe,
                    'givenRating' => $givenRating,
                    'numberOfRatings' => $numberOfRatings,
                    'averageRating' => $averageRating
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

                $this->get('session')->getFlashBag()->add('success', 'Dodawanie przebiegło pomyślnie. Przepis oczekuję na akceptacje.');

                $url = $this->generateUrl('home');

                return $this->redirect($url);
            }
        }
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
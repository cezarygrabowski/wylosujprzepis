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
        $recipe = $form->getData();
        $recipe->setAuthor($this->getUser()->getUsername());
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
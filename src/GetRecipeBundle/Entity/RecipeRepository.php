<?php
/**
 * Created by PhpStorm.
 * User: czarek
 * Date: 2016-09-01
 * Time: 13:16
 */

namespace GetRecipeBundle\Entity;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
class RecipeRepository extends Controller
{
    public function submitForm(Request $request, Form $form)
    {
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if($form->isValid() && $form->isSubmitted())
            {
                $recipe = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em -> persist($recipe);
                $em ->flush();

                $this->get('session')->getFlashBag()->add('success','Wszystko śmiga!');
                $url = $this->generateUrl('home');

                return $this->redirect($url);
            };
        }
    }
}
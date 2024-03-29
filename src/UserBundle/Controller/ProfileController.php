<?php
/**
 * Created by PhpStorm.
 * User: Czaro
 * Date: 2016-10-30
 * Time: 13:51
 */

namespace UserBundle\Controller;
use GetRecipeBundle\Controller\CzaroController as BaseController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use GetRecipeBundle\Entity\RecipeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use UserBundle\Form\LogoChanger;
class ProfileController extends BaseController
{
    /**
     * @return RecipeRepository
     */
    protected function getRecipeRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('GetRecipeBundle:Recipe');
    }

    /**
     * @Route("/profile/change_logo", name="change_logo")
     */
    public function changeLogoAction(Request $request)
    {
        $currentLogo = $this->getUser()->getImage();
        $user = $this->getUser();
        $form = $this->createForm(LogoChanger::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($currentLogo!= "defaultImage.png"){
                $this->RemoveFile($this->getParameter('logo_directory'), $currentLogo);
            }
            // $file stores the uploaded image file
            /** @var UploadedFile $file */
            $file = $user->getImage();
            // Generate a unique name for the file before saving it
            $fileName = $this->get('app.logo_uploader')->upload($file);

            $user->setImage($fileName);

            // ... persist the $user variable or any other work

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('fos_user_profile_show'));
        }

        return $this->render('@FOSUser/Profile/change_logo.html.twig', array(
            'form' => $form->createView()
        ));

    }




    /**
     * Show the user
     */
    public function showAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $acceptedRecipes = $this->getRecipeRepository()->getAcceptedRecipesOfUser($this->getUser()->getId());
        $unacceptedRecipes = $this->getRecipeRepository()->getUnacceptedRecipesOfUser($this->getUser()->getId());
        return $this->render('FOSUserBundle:Profile:show.html.twig', array(
            'user' => $user,
            'acceptedRecipes' => $acceptedRecipes,
            'unacceptedRecipes' => $unacceptedRecipes
        ));
    }
    /**
     * @Route("/profile/unaccepted-recipes", name="unaccepted_recipes")
     */
    public function showUnacceptedRecipesAction()
    {
        $user = $this->getUser();
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }
        $unacceptedRecipes = $this->getRecipeRepository()->getUnacceptedRecipesOfUser($this->getUser()->getId());
        $acceptedRecipes = $this->getRecipeRepository()->getAcceptedRecipesOfUser($this->getUser()->getId());

        return $this->render('@FOSUser/Profile/unacceptedRecipes.html.twig',array(
            'user' => $user,
            'unacceptedRecipes' => $unacceptedRecipes,
            'acceptedRecipes' => $acceptedRecipes
        ));
    }
}
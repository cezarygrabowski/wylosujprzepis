<?php

namespace GetRecipeBundle\Controller;
use Doctrine\DBAL\Types\TextType;
use GetRecipeBundle\Form\GetRecipeForm;
use GetRecipeBundle\Form\UploadRecipeType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use GetRecipeBundle\Entity\Recipe;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Session\Session;
use GetRecipeBundle\Entity\RecipeRepository;
class RecipeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('GetRecipeBundle:Default:index.html.twig');
    }

    /**
     * @Route("/sniadanie", name="sniadanie")
     */
    public function sniadanieAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe)
            ->add('components', ChoiceType::class, array(
                'label' => 'Wybierz składniki:',
                'multiple' =>true,
                'expanded' =>true,
                'choices'  => array(
                    'Płatki owsiane' => 'platki owsiane',
                    'Banan' => 'banan',
                    'Masło orzechowe' => 'maslo orzechowe',
                    'Migdały' => 'migdały',
                    'Jajka' => 'jajka',
                    'Mleko' => 'mleko',
                    'Orzechy' => 'orzechy',
                    'Jogurt naturalny' => 'jogurt naturalny',
                    'Serek mascarpone' => 'serek mascarpone',
                    'Truskawki' => 'truskawka',
                    'Czekolada gorzka' => 'czekolada gorzka',
                    'Miód' => 'miod',
                    'Biały Ser' => 'bialyser',
                    'Dowolne składniki' => 'dowolneskladniki'
                )));

        $form->getData()->setType('sniadanie');
        $form->setData($form->getData());
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if($form->get('components')->isValid() && $form->get('time')->isValid())
            {

                $em = $this->getDoctrine()->getManager();

                $randomRecipe = $em->getRepository('GetRecipeBundle:Recipe')
                    ->getRandomRecipe($form);

                return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig',array(
                    'randomRecipe' => $randomRecipe,

                ));

            }
            return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
                'form' => $form->createView()));
        }
        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/obiad", name="obiad")
     */
    public function obiadAction(Request $request)
    {
        $recipe = new Recipe();

            $form = $this->createForm(GetRecipeForm::class, $recipe)
            ->add('components', ChoiceType::class, array(
                'label' => 'Wybierz składniki:',
                'multiple' =>true,
                'expanded' =>true,
                'choices'  => array(
                    'Wieprzowina' => 'wieprzowina',
                    'Wołowina' => 'wolowina',
                    'Kurczak' => 'kurczak',
                    'Baranina' => 'baranina',
                    'Tuńczyk' => 'tunczyk',
                    'Łosoś' => 'losos',
                    'Ryż' => 'ryz',
                    'Ziemniaki' => 'ziemniaki',
                    'Makaron' => 'makaron',
                    'Kasza gryczana' => 'kasza gryczna',
                    'Orzechy' => 'orzechy',
                    'Marchew' => 'marchew',
                    'Cebula' => 'cebula',
                    'Sałata' => 'salata',
                    'Dowolne Składniki' => 'dowolneskladniki'
                )));

        $form->getData()->setType('obiad');
        $form->setData($form->getData());
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if($form->get('components')->isValid() && $form->get('time')->isValid())
            {

                $em = $this->getDoctrine()->getManager();

                $randomRecipe = $em->getRepository('GetRecipeBundle:Recipe')
                    ->getRandomRecipe($form);


                return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig',array(
                    'randomRecipe' => $randomRecipe,
                ));

            }
            return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
                'form' => $form->createView()));
        }
        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/kolacja", name="kolacja")
     */
    public function kolacjaAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe)
            ->add('components', ChoiceType::class, array(
                'label' => 'Wybierz składniki:',
                'multiple' =>true,
                'expanded' =>true,
                'choices'  => array(
                    'Biały Ser' => 'bialy ser',
                    'Tuńczyk' => 'tunczyk',
                    'Serek Wiejski' => 'ser wiejski',
                    'Cukinia' => 'cukinia',
                    'Marchew' => 'marchew',
                    'Orzechy' => 'orzechy',
                    'Pierś z kurczaka' => 'piers z kurczaka',
                    'Dowolne Składniki' => 'dowolneskladniki'
                )));
        $form->getData()->setType('kolacja');
        $form->setData($form->getData());
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if($form->get('components')->isValid() && $form->get('time')->isValid())
            {

                $em = $this->getDoctrine()->getManager();
                //die(gettype('%'.implode('%', $form->get('components')->getData()).'%'));
                $randomRecipe = $em->getRepository('GetRecipeBundle:Recipe')
                    ->getRandomRecipe($form);


                return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig',array(
                    'randomRecipe' => $randomRecipe,
                ));

            }
            return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
                'form' => $form->createView()));
        }
        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/deser", name="deser")
     */
    public function deserAction(Request $request)
    {
        $recipe = new Recipe();

        $form = $this->createForm(GetRecipeForm::class, $recipe)
            ->add('components', ChoiceType::class, array(
                'label' => 'Wybierz składniki:',
                'multiple' =>true,
                'expanded' =>true,
                'choices'  => array(
                    'Płatki owsiane' => 'platki owsiane',
                    'Banan' => 'banan',
                    'Masło orzechowe' => 'maslo orzechowe',
                    'Migdały' => 'migdały',
                    'Jajka' => 'jajka',
                    'Mleko' => 'mleko',
                    'Orzechy' => 'orzechy',
                    'Jogurt naturalny' => 'jogurt naturalny',
                    'Serek mascarpone' => 'serek mascarpone',
                    'Truskawki' => 'truskawka',
                    'Czekolada gorzka' => 'czekolada gorzka',
                    'Miód' => 'miod',
                    'Biały Ser' => 'bialyser',
                    'Dowolne Składniki' => 'dowolneskladniki'
                )));
        $form->getData()->setType('deser');
        $form->setData($form->getData());
        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {
            if($form->get('components')->isValid() && $form->get('time')->isValid())
            {

                $em = $this->getDoctrine()->getManager();
                //die(gettype('%'.implode('%', $form->get('components')->getData()).'%'));
                $randomRecipe = $em->getRepository('GetRecipeBundle:Recipe')
                    ->getRandomRecipe($form);


                return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig',array(
                    'randomRecipe' => $randomRecipe,
                ));

            }
            return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
                'form' => $form->createView()));
        }
        return $this->render('GetRecipeBundle:GetRecipe:GetRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }



    /**
     * @Route("/dodaj-przepis", name="dodaj_przepis")
     */
    public function dodajPrzepisAction()
    {
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipe.html.twig');
    }

    /**
     * @Route("/dodaj-sniadanie", name="dodaj_sniadanie")
     */
    public function dodajSniadanieAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createForm(UploadRecipeType::class, $recipe);

        $form->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' =>true,
            'expanded' =>true,
            'mapped' => true,
            'choices' => array(
                'Płatki owsiane' => 'platki owsiane',
                'Banan' => 'banan',
                'Masło orzechowe' => 'maslo orzechowe',
                'Migdały' => 'migdały',
                'Jajka' => 'jajka',
                'Mleko' => 'mleko',
                'Orzechy' => 'orzechy',
                'Jogurt naturalny' => 'jogurt naturalny',
                'Serek mascarpone' => 'serek mascarpone',
                'Truskawki' => 'truskawka',
                'Czekolada gorzka' => 'czekolada gorzka',
                'Miód' => 'miod',
                'Biały Ser' => 'bialyser',
                'Nie widzę tu moich składników' => 'brakskladnikow'
        )));

        $form->getData()->setType('sniadanie');
        $form->setData($form->getData());

        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {

            if($form->isValid() && $form->isSubmitted())
            {

                $recipe = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em -> persist($recipe);
                $em ->flush();

                $session = new Session();

                $this->get('session')->getFlashBag()->add('success','Dodawanie przebiegło pomyślnie. Przepis oczekuje na akceptacje.');

                $url = $this->generateUrl('home');

                return $this->redirect($url);
            }
            return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
                'form' => $form->createView()));
        }
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/dodaj-obiad", name="dodaj_obiad")
     */
    public function dodajObiadAction(Request $request)
    {

        $recipe = new Recipe();
        $form = $this->createForm(UploadRecipeType::class, $recipe);

        $form->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' =>true,
            'expanded' =>true,
            'choices'  => array(
                'Wieprzowina' => 'wieprzowina',
                'Wołowina' => 'wolowina',
                'Kurczak' => 'kurczak',
                'Baranina' => 'baranina',
                'Tuńczyk' => 'tunczyk',
                'Łosoś' => 'losos',
                'Ryż' => 'ryz',
                'Ziemniaki' => 'ziemniaki',
                'Makaron' => 'makaron',
                'Kasza gryczana' => 'kasza gryczna',
                'Orzechy' => 'orzechy',
                'Marchew' => 'marchew',
                'Cebula' => 'cebula',
                'Sałata' => 'salata',
                'Nie widzę tu moich składników' => 'brakskladnikow'
            )));

        $form->getData()->setType('obiad');
        $form->setData($form->getData());

        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {

            if($form->isValid() && $form->isSubmitted())
            {


                $recipe = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em -> persist($recipe);
                $em ->flush();

                $session = new Session();

                $this->get('session')->getFlashBag()->add('success','Dodawanie przebiegło pomyślnie. Przepis oczekuje na akceptacje.');

                $url = $this->generateUrl('home');

                return $this->redirect($url);
            }
            return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
                'form' => $form->createView()));
        }
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/dodaj-kolacje", name="dodaj_kolacje")
     */
    public function dodajKolacjeAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createForm(UploadRecipeType::class, $recipe);

        $form->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' =>true,
            'expanded' =>true,
            'choices'  => array(
                'Biały Ser' => 'bialy ser',
                'Tuńczyk' => 'tunczyk',
                'Serek Wiejski' => 'ser wiejski',
                'Cukinia' => 'cukinia',
                'Marchew' => 'marchew',
                'Orzechy' => 'orzechy',
                'Pierś z kurczaka' => 'piers z kurczaka',
                'Nie widzę tu moich składników' => 'brakskladnikow'
            )));

        $form->getData()->setType('kolacja');
        $form->setData($form->getData());

        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {

            if($form->isValid() && $form->isSubmitted())
            {


                $recipe = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em -> persist($recipe);
                $em ->flush();

                $session = new Session();

                $this->get('session')->getFlashBag()->add('success','Dodawanie przebiegło pomyślnie. Przepis oczekuje na akceptacje.');

                $url = $this->generateUrl('home');

                return $this->redirect($url);
            }
            return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
                'form' => $form->createView()));
        }
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));


    }

    /**
     * @Route("/dodaj-deser", name="dodaj_deser")
     */
    public function dodajDeserAction(Request $request)
    {
        $recipe = new Recipe();
        $form = $this->createForm(UploadRecipeType::class, $recipe);

        $form->add('components', ChoiceType::class, array(
            'label' => 'Wybierz składniki:',
            'multiple' =>true,
            'expanded' =>true,
            'choices'  => array(
                'Płatki owsiane' => 'platki owsiane',
                'Banan' => 'banan',
                'Masło orzechowe' => 'maslo orzechowe',
                'Migdały' => 'migdały',
                'Jajka' => 'jajka',
                'Mleko' => 'mleko',
                'Orzechy' => 'orzechy',
                'Jogurt naturalny' => 'jogurt naturalny',
                'Serek mascarpone' => 'serek mascarpone',
                'Truskawki' => 'truskawka',
                'Czekolada gorzka' => 'czekolada gorzka',
                'Miód' => 'miod',
                'Biały Ser' => 'bialyser',
                'Nie widzę tu moich składników' => 'brakskladnikow'
            )));

        $form->getData()->setType('deser');
        $form->setData($form->getData());

        $form->handleRequest($request);
        if ($request->getMethod() == 'POST')
        {

            if($form->isValid() && $form->isSubmitted())
            {


                $recipe = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em -> persist($recipe);
                $em ->flush();

                $session = new Session();

                $this->get('session')->getFlashBag()->add('success','Dodawanie przebiegło pomyślnie. Przepis oczekuje na akceptacje.');

                $url = $this->generateUrl('home');

                return $this->redirect($url);
            }
            return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
                'form' => $form->createView()));
        }
        return $this->render('GetRecipeBundle:UploadRecipe:UploadRecipeForm.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/wynik-losowania", name="wynik_losowania")
     */
    public function wynik_losowaniaAction()
    {
        return $this->render('GetRecipeBundle:GetRecipe:ResultOfQuery.html.twig');
    }
    /**
     * @Route("/akceptuj-przepisy", name="akceptuj_przepisy")
     */
    public function akceptuj_przepisyAction(Request $request)
    {
        $formPassword = $this->createFormBuilder()->getForm();
        $formPassword->add('haslo',PasswordType::class,array(
        ));
        $formPassword->handleRequest($request);
        if($request->getMethod() == 'POST')
        {
            if($formPassword->get('haslo')->getData() == 'AOCE2270Sw')
            {
                return $this->redirect($this->generateUrl('panel_admina'));
            }
        }

        return $this->render('GetRecipeBundle:confirmRecipes:confirmRecipes.html.twig',array(
            'formPassword' => $formPassword->createView()
        ));
    }

    /**
     * @Route("/panel-admina", name="panel_admina")
     */
    public function panel_adminaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $recipeToAccept = $this->getRecipeRepository()
            ->acceptRecipes();




        if($request->query->has('acceptRecipe'))
        {

            foreach($recipeToAccept as $recipe) {

                $recipe->setAccepted(1);
                $em->persist($recipe);
                $em->flush();
                //die();
                //var_dump(get_class($recipe));
                //die();
                //var_dump($em->getClassMetadata(get_class($recipe)));

                //var_dump($em->getClassMetadata(get_class($recipe))->getName());

            }

        }

        return $this->render('GetRecipeBundle:confirmRecipes:adminPanel.html.twig',array(
            'recipeToAccept' => $recipeToAccept,
        ));
    }
        /**
         * @return RecipeRepository
         */
        protected function getRecipeRepository()
    {
        return $this->getDoctrine()->getManager()->getRepository('GetRecipeBundle:Recipe');
    }


}

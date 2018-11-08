<?php

    namespace AppBundle\Controller;

    use AppBundle\Entity\User;
    use AppBundle\Entity\Categorie;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;

    class ManageUsersController extends Controller {
        function suscribeAction(Request $request) {
            $user = new User();

            $form = $this->createFormBuilder($user)
                ->add('name', TextType::class)
                ->add('password', PasswordType::class)
                ->add('save', SubmitType::class, array('label' => 'S\'inscrire'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('homepage');
            }

            return $this->render('default/connexion.html.twig', array(
                'form' => $form->createView()
            ));
        }

        function connectionAction() {

        }
    }
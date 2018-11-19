<?php

    namespace AppBundle\Controller;

    use AppBundle\Entity\User;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\PasswordType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
    use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

    class ManageUsersController extends Controller {
        function suscribeAction(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
            $user = new User();

            $form = $this->createFormBuilder($user)
                ->add('username', TextType::class)
                ->add('password', PasswordType::class)
                ->add('save', SubmitType::class, array('label' => 'S\'inscrire'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());

                $user->setPassword($password);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                return $this->redirectToRoute('homepage');
            }

            return $this->render('default/suscribe.html.twig', array(
                'form' => $form->createView()
            ));
        }

        function connectionAction(AuthenticationUtils $authenticationUtils) {
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('default/connexion.html.twig', array(
                'last_username' => $lastUsername,
                'error'         => $error
            ));
        }
    }
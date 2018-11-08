<?php

    namespace AppBundle\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
    use Symfony\Component\DependencyInjection\ContainerInterface;

    class ContactController extends Controller {
        private $mailjetMailer;

        public function formContactAction(Request $request) {
            $form = $this->createFormBuilder()
                ->add('name', TextType::class, array(
                    'label' => 'Nom'
                ))
                ->add('surname', TextType::class, array(
                    'label' => 'Prénom'
                ))
                ->add('email', TextType::class, array(
                    'label' => 'Email'
                ))
                ->add('message', TextareaType::class, array(
                    'label' => 'Message'
                ))
                ->add('save', SubmitType::class, array(
                    'label' => 'Contacter'
                ))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $test = $form->getData();

                $template = $this->container->get('twig')->render('registration.html.twig', [
                    'name' => $test['name']
                ]);

                $mailer = $this->get('mailjet_mailer');

                $mailer
                    ->setEmailFrom('simon@spin-interactive.com')
                    ->setNameFrom('Test')
                    ->addRecipient('simon.gioffredi@gmail.com')
                    ->setSubject('Hello Email WIth Service')
                    ->setContent($template)
                    ->setHtmlPart($template)
                    ->send();

                return $this->redirectToRoute('contact');
            }

            return $this->render('default/open.html.twig', array(
                'form' => $form->createView()
            ));
        }
    }

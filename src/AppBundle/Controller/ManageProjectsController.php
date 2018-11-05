<?php

    namespace AppBundle\Controller;

    use AppBundle\Entity\Project;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    class ManageProjectsController extends Controller {
        public function addProjectAction(Request $request) {
            $project = new Project();
            // creates a task and gives it some dummy data for this example

            $form = $this->createFormBuilder($project)
                ->add('name', TextType::class)
                ->add('description', TextType::class)
                ->add('image', TextType::class)
                //            ->add('image', FileType::class, array('data_class' => null))
                ->add('save', SubmitType::class, array('label' => 'Create Project'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $project = $form->getData();

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($project);
                $entityManager->flush();

                return $this->redirectToRoute('homepage');
            }

            return $this->render('default/add.html.twig', array(
                'form' => $form->createView(),
            ));
        }


        public function removeProjectAction($idProject) {
            $entityManager = $this->getDoctrine()->getManager();
            $projects = $entityManager->getRepository('AppBundle:Project');
            $project = $projects->find($idProject);

            $entityManager->remove($project);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }
    }
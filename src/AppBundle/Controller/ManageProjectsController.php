<?php

    namespace AppBundle\Controller;

    use AppBundle\Entity\Project;
    use AppBundle\Entity\Categorie;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\File\UploadedFile;
    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType;

    class ManageProjectsController extends Controller {
        public function createFormCustom($request, $idProject = null) {
            if ($idProject === null) {
                $project = new Project();
                $title = 'Create a Project';
            } else {
                $title = 'Update a Project';
                $em = $this->getDoctrine()->getManager();
                $project = $em->getRepository('AppBundle:Project')->find($idProject);
            }
            $directory = $this->getParameter('upload_directory');

            $form = $this->createFormBuilder($project)
                ->add('name', TextType::class)
                ->add('description', TextType::class)
                ->add('image', FileType::class, array('data_class' => null))
                ->add('categorie', EntityType::class, array(
                    'class' => Categorie::class,
                    'choice_label' => 'name'
                ))
                ->add('save', SubmitType::class, array('label' => $title))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $project = $form->getData();


                $file = $form['image']->getData();
                $fileName = $file->getClientOriginalName();
                $file->move($directory, $fileName);

                $project->setImage($fileName);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($project);
                $entityManager->flush();

                return $this->redirectToRoute('homepage');
            }

            return $this->render('default/add.html.twig', array(
                'form' => $form->createView(),
                'title' => $title
            ));
        }

        public function addProjectAction(Request $request) {
            return $this->createFormCustom($request);
        }

        public function removeProjectAction($idProject) {
            $entityManager = $this->getDoctrine()->getManager();
            $project = $entityManager->getRepository('AppBundle:Project')->find($idProject);

            $entityManager->remove($project);
            $entityManager->flush();

            return $this->redirectToRoute('homepage');
        }

        public function updateProjectAction(Request $request, $idProject) {
            return $this->createFormCustom($request, $idProject);
        }

        public function filterByCategorieAction($categorieSlug) {
            $entityManager = $this->getDoctrine()->getManager();
            $projects = $entityManager->getRepository('AppBundle:Project')->findBy(
                array('categorie' => $categorieSlug)
            );
            $categories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findAll();

            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                'projects' => $projects,
                'categories' => $categories
            ]);
        }

        public function openProjectAction($idProject) {
            $entityManager = $this->getDoctrine()->getManager();
            $project = $entityManager->getRepository('AppBundle:Project')->find($idProject);

            return $this->render('default/card-open.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                'project' => $project
            ]);
        }
    }
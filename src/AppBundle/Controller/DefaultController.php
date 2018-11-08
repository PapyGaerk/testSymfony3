<?php

    namespace AppBundle\Controller;

    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\HttpFoundation\Request;

    class DefaultController extends Controller {
        public function indexAction(Request $request) {
            $projects = $this->getDoctrine()->getRepository('AppBundle:Project')->findAll();
            $categories = $this->getDoctrine()->getRepository('AppBundle:Categorie')->findAll();
            $directory = $this->getParameter('upload_directory');
            // replace this example code with whatever you need
            return $this->render('default/index.html.twig', [
                'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                'projects' => $projects,
                'categories' => $categories,
                'uploads' => $directory
            ]);
        }
    }

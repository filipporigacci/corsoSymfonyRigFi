<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }
    /**
     * @Route("/helloWorld")
     */
    public function homeAction()
    {
        $st1 = "Hello World!";
        $st2 = "I'm default AppBundle's index.htm.twig from local xampp";
        return $this->render('AppBundle:Default:home.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'saluto1' => $st1,
            'saluto2' => $st2
        ]);
    }
}

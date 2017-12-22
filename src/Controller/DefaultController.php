<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        // $user = $this->getUser();
        // $em = $this->getDoctrine()->getEntityManager();
        return $this->render('Default/index.html.twig');
    }
}

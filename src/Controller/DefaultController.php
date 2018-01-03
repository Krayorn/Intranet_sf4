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
        return $this->render('Default/index.html.twig');
    }

    /**
     * @Route("/student", name="student")
     */
    public function studentAction()
    {
        if($this->isGranted('ROLE_USER')) {
            return $this->render('Default/student.html.twig');
        }
        return $this->render('Default/index.html.twig');
    }

    /**
     * @Route("/teacher", name="teacher")
     */
    public function teacherAction()
    {
        if($this->isGranted('ROLE_TEACHER')) {
            return $this->render('Default/teacher.html.twig');
        }
        return $this->render('Default/index.html.twig');
    }
}

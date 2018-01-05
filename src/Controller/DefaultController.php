<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Repository;
use App\Entity;

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
        if(!$this->isGranted('ROLE_USER')) {
            return $this->render('Default/index.html.twig');
        }

        $em = $this->getDoctrine()->getEntityManager();
        $request = Request::createFromGlobals();
        $subjectRepository = $em->getRepository('App\Entity\Subject');

        $user = $this->getUser();
        $student_subject = $user->getSubjects();
        $all_subjects = $subjectRepository->findAll();

        $allGrades =  $em->getRepository('App\Entity\Grades')->getGradesForUser($user);

        $grades = [];
        foreach($allGrades as $grade) {
            if (!isset($grades[$grade->getSubjects()->getTitle()]['grades'])) {
                $grades[$grade->getSubjects()->getTitle()]['grades'] = [];
            }
            array_push($grades[$grade->getSubjects()->getTitle()]['grades'], $grade);
        }

        foreach($grades as $subject => $subjectGrades) {
            $sum = 0;
            foreach($grades[$subject]['grades'] as $grade) {
                $sum += $grade->getGrade();
            }
            $grades[$subject]['average'] = $sum / count($grades[$subject]['grades']);
        }

        if ($request->getMethod() === 'POST') {
            $idSubject = $request->get('subject');
            $subject = $subjectRepository->findOneById($idSubject);
            if($subject !== null) {
                $user->addSubject($subject);
                $em->flush();
            }
        }

        return $this->render('Default/student.html.twig',
            ['subjects' => $all_subjects,
            'student_subject' => $student_subject,
            'grades' => $grades]);
    }

    /**
     * @Route("/teacher", name="teacher")
     */
    public function teacherAction()
    {
        if(!$this->isGranted('ROLE_TEACHER')) {
            return $this->render('Default/index.html.twig');
        }
        return $this->render('Default/teacher.html.twig');
    }
}

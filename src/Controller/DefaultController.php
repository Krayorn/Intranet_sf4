<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository;
use App\Entity\Grades;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        if($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin');
        } else if($this->isGranted('ROLE_TEACHER')) {
            return $this->redirectToRoute('teacher');
        } else if($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('student');
        } else {
            return $this->redirectToRoute('login');
        }
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
        $allGrades =  $user->getGrades();
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

        $choices = [];
        foreach($all_subjects as $subject) {
            $alreadySubscribed = false;
            foreach($student_subject as $studentSubject) {
                if ($studentSubject->getTitle() == $subject->getTitle()) {
                    $alreadySubscribed = true;
                }
            }
            if(!$alreadySubscribed) {
                $choices[$subject->getTitle()] = $subject->getId();
            }
        }

        if ($choices === []) {
            $all_subjects = null;
        }

        $form = $this->createFormBuilder()
            ->setMethod("Post")
            ->add('subject', ChoiceType::class, array(
                'choices'  => $choices))
            ->add('save', SubmitType::class, array('label' => 'Subscripe to subject'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $idSubject = $data['subject'];
            $subject = $subjectRepository->findOneById($idSubject);
            if($subject !== null) {
                $user->addSubject($subject);
                $em->flush();
            }
        }

        return $this->render('Default/student.html.twig',
            ['subjects' => $all_subjects,
            'student_subject' => $student_subject,
            'grades' => $grades,
            'form' => $form->createView()]);
    }
    /**
     * @Route("/teacher", name="teacher")
     */
    public function teacherAction()
    {
        if(!$this->isGranted('ROLE_TEACHER')) {
            return $this->render('Default/index.html.twig');
        }
        $teacher = $this->getUser();
        $teacher_subjects = $teacher->getSubjects();

        return $this->render('Default/teacher.html.twig',
            ['teacher_subjects' => $teacher_subjects]);
    }
    /**
   * @Route("/create/grade/{slug}", name="create_grade")
   */
    public function createGradesAction($slug)
    {
    if(!$this->isGranted('ROLE_TEACHER')) {
        return $this->render('Default/index.html.twig');
    }

    $request = Request::createFromGlobals();
    $em = $this->getDoctrine()->getEntityManager();
    $user = $em->getRepository('App\Entity\User')->findOneById($slug);
    $subject = $em->getRepository('App\Entity\Subject')->findOneById($request->get('subject_id'));
    if ($request->getMethod() === 'POST') {
        $grade = new Grades;
        $grade -> setUsers($user);
        $grade -> setSubjects($subject);
        $grade -> setGrade($request->get('grade'));
        $grade -> setCommentary($request->get('commentary_create'));

        $em->persist($grade);
        $em->flush();
        return $this->redirectToRoute('teacher');
    }
    }
}

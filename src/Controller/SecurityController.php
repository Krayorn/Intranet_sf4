<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\User;

class SecurityController extends Controller
{

    /**
     * @Route("/register", name="register")
     */
    public function registerAction()
    {
        $request = Request::createFromGlobals();
        $em = $this->getDoctrine()->getEntityManager();
        // $rep = $em->getRepository('TicketBundle:User');

        if ($request->getMethod() === 'POST')
        {
            $user = new User;
            $user -> setFirstname($request->get('firstname_create'));
            $user -> setLastname($request->get('lastname_create'));
            $user -> setEmail($request->get('email_create'));
            $user -> setUsername($request->get('username_create'));
            $user->setCreatedAt(new \DateTime);
            $user -> setRole(array('ROLE_ADMIN'));
            $hash = $this->get('security.password_encoder')->encodePassword($user,$request->get('password_create'));
            $user -> setPassword($hash);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('Security/register.html.twig');
    }


    /**
    * @Route("/login", name="login")
    */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        $em = $this->getDoctrine()->getManager();

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
        'Security/login.html.twig',
        array(
        'last_username' => $lastUsername,
        'error'         => $error,
        ));
    }

    /**
    * @Route("/login_check", name="login_check")
    */
    public function loginCheckAction()
    {

    }

    /**
    * @Route("/logout", name="logout")
    */
    public function logoutAction()
    {

    }
}

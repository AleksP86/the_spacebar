<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\User;


use App\Security\LoginFormAuthenticator;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;


class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
    	$error=$authenticationUtils->getLastAuthenticationError();
    	$lastUserName=$authenticationUtils->getLastUserName();

    	//dump($authenticationUtils);
    	//dump($error);
    	//dump($lastUserName);
        return $this->render('security/login.html.twig'
        	, [
        	'lastUserName'=>$lastUserName,
    		'error'=>$error
        ]);
    }

    /**
    * @Route("/logout", name="app_logout")
    */
    public function logout(SessionInterface $session)
    {
    	$session->remove('logged_user');
    	// intercepted in config/packages/security.yaml on row logout: path: app_logout
    	throw new \Exception('Will be intercepted before getting here');
    }

    /**
    * @Route("/register", name="app_register")
    */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $formAuthenticator)
    {
        if($request->isMethod('POST'))
        {
            $user = new User();
            $user->setEmail($request->request->get('email'));
            $user->setFirstName('Mystery');

            $user->setUserName('Mystery');
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password') ) );
            $user->setRoles($user->getRoles());
            $user->setCreatedDate(new \DateTime() );//new \DateTime('@'.strtotime('now')) 

            //dd($user);

            $em=$this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            //return $this->redirectToRoute('app_login');//app_account
            return $guardHandler->authenticateUserAndHandleSuccess($user,$request,$formAuthenticator,'main');
        }
        return $this->render('security/register.html.twig');
    }
}

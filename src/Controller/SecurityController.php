<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

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
}

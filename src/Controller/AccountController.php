<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use Psr\Log\LoggerInterface;

/**
 * @IsGranted("ROLE_USER")
 */

class AccountController extends BaseController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index(LoggerInterface $logger)
    {
    	//$logger->debug('Checking account page for '.$this->getUser()->getEmail());
    	//dd($this->getUser() );
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    /**
    * @Route("/api/account", name="api_account")
    */
    public function accountApi()
    {
        $user=$this->getUser();
        //dd($user);
        //return $this->json($user);
        return $this->json($user, 200, [], ['groups'=>['main'] ]);
    }
}

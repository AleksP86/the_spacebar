<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;

class WelcomeController extends AbstractController
{
    /**
     * @Route("/", name="welcome")
     */
    public function index()
    {
        return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);
    }

    /**
    * @Route("/home", name="homepage")
    */
    public function homepage()
    {
    	return new Response('Homepage.');
    }

    /**
    * @Route("/news/{slug}")
    */
    public function show($slug)
    {
    	$comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        var_dump($slug);

    	return $this->render('article/show.html.twig',
    		[
    			'title'=>ucwords(str_replace('-',' ',$slug)),
    			'comments'=>$comments
    	]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;


use App\Entity\Article;
//use App\Service\Markdownhelper;
//use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
//use Psr\Log\LoggerInterface;
//use Twig\Evironment;

class WelcomeController extends AbstractController
{
	
    /**
     * @Route("/", name="welcome")
     */
    public function index( EntityManagerInterface $em)
    {
    	$repository= $em->getRepository(Article::class);
    	$articles=$repository->findAll();

    	dump($articles);

    	return $this->render('article/homepage.html.twig',
    	[
    		'articles'=> $articles
    	]);


    	//return $this->render('article/homepage.html.twig');
        /*return $this->render('welcome/index.html.twig', [
            'controller_name' => 'WelcomeController',
        ]);*/
    }

    /**
    * @Route("/home", name="homepage")
    */
    public function homepage()
    {
    	return new Response('Homepage.');
    }

    /**
    * @Route("/news/{slug}", name="article_show")
    */
    public function show($slug, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        
        $article = $repository->findOneBy(['slug' => $slug]);
        if (!$article)
        {
            //throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
        }

        //dump($article);die;

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
    	     'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        return $this->render('article/show.html.twig', [
        	'article'=>$article,
        	'comments'=>$comments
        ]);

        /*
        $articleContent = <<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
**turkey** shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF;
        
        $articleContent = $markdownHelper->parse($articleContent);
        */

        /*
        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'comments' => $comments,
            'articleContent' => $articleContent,
        ]);
        */
    }
    


    /*
    public function show($slug)
    {
    	$comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
            'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        //var_dump($slug);

    	return $this->render('article/show.html.twig',
    		[
    			'title'=>ucwords(str_replace('-',' ',$slug)),
    			'comments'=>$comments,
    			'slug'=>$slug
    	]);
    }
    */

    /**
    * @Route("/news/{slug}/heart",name="article_toggle_heart", methods={"POST"})
    */
    public function toggleArticleHeart($slug)
    {
    	return new JsonResponse(['hearths'=>rand(5,100)]);
    	return $this->json(['hearths'=>rand(5,100)]);
    }


}

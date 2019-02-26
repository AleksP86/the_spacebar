<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Quotes;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin", name="article_admin")
     */
    public function index(EntityManagerInterface $em)
    {
        //count articles
        $article_count=$this->getDoctrine()->getrepository(Article::class)->countArticles();

        return $this->render('article_admin/index.html.twig',[
            'message'=>'']);
        /*
        return $this->render('article_admin/index.html.twig', [
            'controller_name' => 'ArticleAdminController',
        ]);
        */
    }

    /**
    * @Route("/admin/article/new")
    */
    public function new(EntityManagerInterface $em)
    {
    	//return new Response('space rocks... include comets, asteroids & meteoroids');
    	$article=new Article();
    	$article->setTitle('Why Asteroids Taste Like Bacon')
    		->setSlug('why-asteroids-taste-like-bacon-'.rand(100,999))
    		->setContent('Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
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
fugiat.');

            if(rand(1,10)>2)
    		{
                $article->setPublishedAt(new \DateTime('@'.strtotime('now')) );
    		}

    		$em->persist($article);
    		$em->flush();

    		//return new Response('space rocks... include comets, asteroids & meteoroids');
    		return new Response(sprintf('New article id #%d slug: %s', $article->getId(), $article->getSlug() ) );
    }

    /**
    * @Route("/add_article", name="add_article")
    */
    public function addNewArticle(EntityManagerInterface $em, Request $request)
    {
        $proceed=true;
        if($_POST['title']=='')
        {
            $proceed=false;
        }
        if($_POST['text']=='')
        {
            $proceed=false;
        }

        if($proceed==false)
        {
            return new JsonResponse(['reply'=>false, 'content'=>array($_POST['title'], $_POST['text'])]);
        }
        else
        {
            //save to DB
            $article=new Article();
            $article->setTitle($_POST['title'])
            ->setSlug($_POST['title'].rand(100,999))
            ->setContent($_POST['text'])
            ->setPublishedAt(date_create());

            $em->persist($article);
            $em->flush();

            return new JsonResponse(['reply'=>true, 'content'=>array($article->getId(), $article->getSlug())]);
        }        

        //var_dump($request );
        //var_dump($_POST['title']);
        //return new JsonResponse($_POST['title']);
        //return new JsonResponse(['hearths'=>rand(5,100)]);
        /*return $this->render('article_admin/index.html.twig',[
            'message'=>"show message"]);*/
    }

    /**
    * @Route("/add_quote", name="add_quote")
    */
    public function addNewQuote(EntityManagerInterface $em, Request $request)
    {
        $proceed=true;
        if($_POST['author']=='')
        {
            $proceed=false;
        }
        if($_POST['text']=='')
        {
            $proceed=false;
        }

        if($proceed==false)
        {
            return new JsonResponse(['reply'=>false, 'content'=>array($_POST['author'], $_POST['text'])]);
        }
        else
        {
            //save to DB
            $quote=new Quotes();
            $quote->setAuthor($_POST['author'])
            ->setContent($_POST['text'])
            ->setAddDate(date_create());

            $em->persist($quote);
            $em->flush();

            return new JsonResponse(['reply'=>true, 'content'=>array($quote->getId(), $quote->getAuthor())]);
        }
    }
}

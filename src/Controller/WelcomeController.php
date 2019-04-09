<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Entity\Article;
use App\Entity\Quotes;
use App\Entity\Comment;
use Doctrine\ORM\EntityManagerInterface;

class WelcomeController extends AbstractController
{
	
    /**
     * @Route("/", name="welcome")
     */
    public function index( EntityManagerInterface $em)
    {
    	$articles=$this->getDoctrine()->getRepository(Article::class)->getAllStories();
        $publish_message=array();
        $story_list=array();

    	foreach($articles as $story)
    	{
    		$t=$story->getPublishedAt();
            $message='';
            if($t==null)
            {
                $message="Unpublished.";
            }
            else
            {
                $diff=date_diff(date_create(get_object_vars($t)['date']),date_create());
                
                if($diff->y>1)
                {
                    $message='Article published '.$diff->y." years ago.";
                }
                else if($diff->y==1)
                {
                    $message='Article published '.$diff->y." year ago.";
                }
                else
                {
                    $message='';
                }

                if($message=='')
                {
                    if($diff->m>1)
                    {
                        $message='Article published '.$diff->m." months ago.";
                    }
                    else if($diff->m==1)
                    {
                        $message='Article published '.$diff->m." month ago.";
                    }
                }

                if($message=='')
                {
                    if($diff->d>1)
                    {
                        $message='Article published '.$diff->d." days ago.";
                    }
                    elseif($diff->d==1)
                    {
                        $message='Article published '.$diff->d." day ago.";
                    }
                }

                if($message=='')
                {
                    if($diff->h>1)
                    {
                        $message='Article published '.$diff->h." hours ago.";
                    }
                    elseif($diff->h==1)
                    {
                        $message='Article published '.$diff->h." hour ago.";
                    }
                }

                if($message=='')
                {
                    if($diff->i>1)
                    {
                        $message='Article published '.$diff->i." minutes ago.";
                    }
                    else
                    {
                        $message="Article published few minutes ago.";
                    }
                }
            }
            //var_dump($message);
            $publish_message[]=$message;
            //die();

            $story_list[]=array('title'=>$story->getTitle(), 'slug'=>$story->getSlug(), 'release'=>$message, 'author'=>$story->getAuthor());
    	}

    	//$repository= $em->getRepository(Article::class);
    	//$articles=$repository->findAll();

        //$repository = $em->getRepository(Article::class);
        //$articles = $repository->getStoryBySlug('title535');

        $quotes=$this->getDoctrine()->getRepository(Quotes::class)->findAll();
        //var_dump($quotes);
        $quotes_list=array();
        foreach($quotes as $quote)
        {
            //var_dump($quote);
            //echo "<br/>";
            $quotes_list[]=array('author'=>$quote->getAuthor(),'message'=>$quote->getContent(), 'link'=>$quote->getLink());
        }

        //var_dump($quotes_list);


    	return $this->render('article/homepage.html.twig',
    	[
    		'articles'=> $articles,
            'publish_message'=>$publish_message,
            'story_data'=>$story_list,
            'quotes_list'=>$quotes_list
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
        $diff=date_diff(date_create( get_object_vars($article->getPublishedAt())['date'] ),date_create());
        //dump($diff);

        $message='';
        if($diff->y>1)
        {
            $message=$diff->y." years ago.";
        }
        else if($diff->y==1)
        {
            $message=$diff->y." year ago.";
        }
        else
        {
            $message='';
        }

        if($message=='')
        {
            if($diff->m>1)
            {
                $message=$diff->m." months ago.";
            }
            else if($diff->m==1)
            {
                $message=$diff->m." month ago.";
            }
        }

        if($message=='')
        {
            if($diff->d>1)
            {
                $message=$diff->d." days ago.";
            }
            elseif($diff->d==1)
            {
                $message=$diff->d." day ago.";
            }
        }

        if($message=='')
        {
            if($diff->h>1)
            {
                $message=$diff->h." hours ago.";
            }
            elseif($diff->h==1)
            {
                $message=$diff->h." hour ago.";
            }
        }

        if($message=='')
        {
            if($diff->i>1)
            {
                $message=$diff->i." minutes ago.";
            }
            else
            {
                $message="few minutes ago.";
            }
        }

        //var_dump($message);
        //die;

        $comments = [
            'I ate a normal rock once. It did NOT taste like bacon!',
            'Woohoo! I\'m going on an all-asteroid diet!',
    	     'I like bacon too! Buy some from my site! bakinsomebacon.com',
        ];

        //get comments from DB

        return $this->render('article/show.html.twig', [
        	'article'=>$article,
        	'comments'=>$comments,
            'commentsDB'=>$this->getDoctrine()->getRepository(Comment::class)->getComments($slug),
            'local_asteroids'=>$slug,
            'publish_time'=>$message
        ]);
    }

    /**
    * @Route("/news/{slug}/heart",name="article_toggle_heart", methods={"POST"})
    */
    public function toggleArticleHeart($slug, Article $article, EntityManagerInterface $em)
    {
        $article->incrementHeartCount();
        //$article->setHeartCount($article->getHeartCount()+1);
        $em->flush();
    	return new JsonResponse(['hearths'=>$article->getHeartCount() ]);
    	//return $this->json(['hearths'=>rand(5,100)]);
    }

    /**
    * @Route("/news/{slug}/comment", name="add_comment", methods={"POST"})
    */
    public function addComment($slug, EntityManagerInterface $em)
    {
        //var_dump($_POST);
        $comment=new Comment();
        $comment->setContent($_POST['message'])
        //->setPublishedAt(date_create())
        ->setArticle($slug)
        ->setAuthorName('Somebody')
        //->setCreatedAt(date_create())
        ;
        
        $em->persist($comment);
        $em->flush();

        return new JsonResponse(['data'=>array($_POST, $slug) ]);
    }


}

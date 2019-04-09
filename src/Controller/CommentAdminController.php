<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Repository\CommentRepository;
use App\Entity\Comment;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManager;

class CommentAdminController extends AbstractController
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     */
    public function index(CommentRepository $repository, Request $request, PaginatorInterface $paginator)
    {
    	$q= $request->query->get('q');
    	$queryBuilder=$repository->getWithSearchQueryBuilder($q);
    	
    	$pagination=$paginator->paginate($queryBuilder, $request->query->getInt('page',1), 3);


    	$comments=$repository->findBy([]);
    	return $this->render('comment_admin/index.html.twig',[
    		'comments'=>$comments,
    		'pagination'=>$pagination
    	]);
    }

    /**
    * @Route("/admin/comment/delete",name="delete_comment")
    */
    public function deleteComment()
    {
    	$entityManager = $this->getDoctrine()->getManager();
	    $com = $entityManager->getRepository(Comment::class)->find($_POST['id']);
	    $com->CommentDeleted();
	    $entityManager->flush();

    	return new JsonResponse($_POST['id']);
    }
}

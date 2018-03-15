<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 26/02/2018
 * Time: 10:55
 */

namespace App\Controller\Admin;


use App\Entity\Comment;
use App\Entity\Post;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/", name="admin_index")
     * @Method("GET")
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        return $this->render('admin/post/index.html.twig', ['posts' => $posts]);
    }

    /**
     * @param Post $posts
     * @return Response
     * @Route("/admin/post/{slug}", name="admin_show")
     */
    public function show(Post $posts): Response
    {
        return $this->render('admin/post/show.html.twig', ['posts' => $posts]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/admin/comment", name="admin_index_comment")
     * @Method("GET")
     */
    public function indexComment(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();

        return $this->render('admin/comment/index.html.twig', ['comments' => $comments]);
    }

    /**
     * @return Response
     * @Route("/admin/comment/{id}", name="admin_show_comment")
     */
    public function showComment(Comment $comment): Response
    {
        return $this->render('admin/comment/show.html.twig', ['comment' => $comment]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 26/02/2018
 * Time: 10:55
 */

namespace App\Controller\Admin;


use App\Entity\Post;
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
        $posts = $postRepository->allArticle();

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
}
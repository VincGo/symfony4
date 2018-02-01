<?php
namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{

    /**
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="list_post")
     */
    public function index(PostRepository $postsRepository): Response
    {
        $posts = $postsRepository->findBy(array(), array('id'=>'desc'));

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/post/{slug}", name="blog_post")
     * @Method("GET")
     *
     */
    public function postShow(Post $post): Response
    {
        return $this->render('post/show.html.twig', ['post' => $post,]);
    }

    public function sideBar(PostRepository $postRepository)
    {
        $infos = $postRepository->infoSideBar();

        return $this->render('post/_widget.html.twig', ['infos' => $infos]);
    }
}
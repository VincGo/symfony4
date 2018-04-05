<?php
namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PostController extends AbstractController
{

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="list_post")
     */
    public function index(PostRepository $postRepository): Response
    {
        $slider = array(38, 39, 40, 41);
        $value = 38;

        $posts = $postRepository->lastNews();
        $slide1 = $postRepository->slider($value);
        $slide2 = $postRepository->slider($value);
        $slide3 = $postRepository->slider($value);
        $slide4 = $postRepository->slider($value);

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'slide1' => $slide1,
            'slide2' => $slide2,
            'slide3' => $slide3,
            'slide4' => $slide4,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/post/{slug}", name="blog_post")
     * @Method("GET")
     *
     */
    public function postShow(Post $post): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $post,]);
    }

    public function sideBar(PostRepository $postRepository)
    {
        $infos = $postRepository->infoSideBar();

        return $this->render('post/_widget.html.twig', ['infos' => $infos]);
    }

    /**
     * @param Post $post
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/article", name="article_post")
     * @Method("GET")
     */
    public function article(PostRepository $postRepository): Response
    {
        $value = $_GET['tag'];

        $post = $postRepository->finByTag($value);

        return $this->render('post/article.html.twig', ['posts' => $post,]);
    }

    public function lastResume(PostRepository $postRepository): Response
    {
        $resumes = $postRepository->lastSection('résumé');
        $fourResumes = $postRepository->fourSection('résumé');

        return $this->render('post/_section_resume.html.twig', [
            'resumes'=> $resumes,
            'fourResumes'=> $fourResumes
        ]);
    }

    public function lastArticle(PostRepository $postRepository): Response
    {
        $articles = $postRepository->lastSection('article');
        $fourArticles = $postRepository->fourSection('article');

        return $this->render('post/_section_article.html.twig', [
            'articles'=> $articles,
            'fourArticles'=> $fourArticles
        ]);
    }
}
<?php
namespace App\Controller;

use App\Entity\Post;
use App\Entity\Tag;
use App\Form\ChatType;
use App\Repository\ChatRepository;
use App\Repository\PostRepository;
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
        $slider = $postRepository->findOneBy(['slider' => 1]);
        $fourSliders = $postRepository->fourSlider();

        return $this->render('post/index.html.twig', [
            'slider' => $slider,
            'fourSliders' => $fourSliders
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/post/{slug}", name="blog_post")
     * @Method("GET")
     */
    public function postShow(Post $post, PostRepository $postRepository): Response
    {
        $relatedArticles = $postRepository->relatedArticle($post);

        return $this->render('post/show.html.twig', [
            'relatedArticles' => $relatedArticles,
            'post' => $post
            ]);
    }

    public function sideBar(PostRepository $postRepository)
    {
        $infos = $postRepository->infoSideBar();

        return $this->render('post/include/_widget.html.twig', ['infos' => $infos]);
    }

    /**
     * @param Post $post
     * @param Tag $tag
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/article/{tag}", name="article_post")
     * @ParamConverter("tag", options={"mapping": {"tag": "name"}})
     * @Method("GET")
     */
    public function article(PostRepository $postRepository,Tag $tag): Response
    {
        $post = $postRepository->finByTag($tag);

        return $this->render('post/article.html.twig', ['posts' => $post,]);
    }

    /**
     * @param Post $post
     * @param Tag $tag
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/team/{tag}", name="team_post")
     * @ParamConverter("tag", options={"mapping": {"tag": "name"}})
     * @ParamConverter("chat", options={"mapping": {"chat": "team"}})
     * @Method("GET")
     */
    public function team(PostRepository $postRepository,Tag $tag, ChatRepository $chatRepository): Response
    {

        $post = $postRepository->finByTag($tag);
        $msgs = $chatRepository->findByTeam($tag);
        $form = $this->createForm(ChatType::class);

        return $this->render('post/team.html.twig', [
            'tag' => $tag,
            'posts' => $post,
            'msgs' => $msgs,
            'form' => $form->createView()
            ]);
    }


    public function lastResume(PostRepository $postRepository): Response
    {
        $resumes = $postRepository->lastSection('résumé');
        $fourResumes = $postRepository->fourSection('résumé');

        return $this->render('post/include/_section_resume.html.twig', [
            'resumes'=> $resumes,
            'fourResumes'=> $fourResumes
        ]);
    }

    public function lastArticle(PostRepository $postRepository): Response
    {
        $articles = $postRepository->lastSection('article');
        $fourArticles = $postRepository->fourSection('article');

        return $this->render('post/include/_section_article.html.twig', [
            'articles'=> $articles,
            'fourArticles'=> $fourArticles
        ]);
    }
}
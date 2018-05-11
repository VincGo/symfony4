<?php
/**
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */

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

/**
 * Class PostController
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  App\Controller
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class PostController extends AbstractController
{
    /**
     * Affichage de la homepage
     *
     * @param PostRepository $postRepository récupère les données pour la homepage
     *
     * @Route("/", name="list_post")
     *
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $slider = $postRepository->findOneBy(['slider' => 1]);
        $fourSliders = $postRepository->fourSlider();

        return $this->render(
            'post/index.html.twig',
            [
                'slider' => $slider,
                'fourSliders' => $fourSliders
            ]
        );
    }

    /**
     * Affiche un post en fonction de son slug
     *
     * @param Post           $post
     * @param PostRepository $postRepository
     *
     * @Route("/post/{slug}", name="blog_post")
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function postShow(Post $post, PostRepository $postRepository): Response
    {
        $relatedArticles = $postRepository->relatedArticle($post);

        return $this->render(
            'post/show.html.twig', [
            'relatedArticles' => $relatedArticles,
            'post' => $post
            ]
        );
    }


    /**
     * Affiche de la sidebar
     *
     * @param PostRepository $postRepository récupère les 10 dernières news
     *
     * @return Response
     */
    public function sideBar(PostRepository $postRepository)
    {
        $infos = $postRepository->infoSideBar();

        return $this->render('post/include/_widget.html.twig', ['infos' => $infos]);
    }

    /**
     * Affichage des articles en fonction du tag
     *
     * @param PostRepository $postRepository
     * @param Tag            $tag
     *
     * @Route("/article/{tag}", name="article_post")
     *
     * @ParamConverter("tag", options={"mapping": {"tag": "name"}})
     *
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function article(PostRepository $postRepository,Tag $tag): Response
    {
        $post = $postRepository->finByTag($tag);

        return $this->render(
            'post/article.html.twig',
            [
                'posts' => $post,
            ]
        );
    }

    /**
     * Affichage des pages team
     *
     * @param PostRepository $postRepository Les posts en fonction de la team
     * @param Tag            $tag
     * @param ChatRepository $chatRepository Derniers messages en fonction de la team
     *
     * @Route("/team/{tag}", name="team_post")
     *
     * @ParamConverter("tag",  options={"mapping": {"tag": "name"}})
     * @ParamConverter("chat", options={"mapping": {"chat": "team"}})
     *
     * @Method("GET")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function team(
        PostRepository $postRepository,Tag $tag, ChatRepository $chatRepository
    ): Response {

        $post = $postRepository->finByTag($tag);
        $msgs = $chatRepository->findByTeam($tag);
        $form = $this->createForm(ChatType::class);

        return $this->render(
            'post/team.html.twig',
            [
                'tag' => $tag,
                'posts' => $post,
                'msgs' => $msgs,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Affiche la section résumé dans la homepage
     *
     * @param PostRepository $postRepository
     *
     * @return Response
     */
    public function lastResume(PostRepository $postRepository): Response
    {
        $resumes = $postRepository->lastSection('résumé');
        $fourResumes = $postRepository->fourSection('résumé');

        return $this->render(
            'post/include/_section_resume.html.twig',
            [
                'resumes'=> $resumes,
                'fourResumes'=> $fourResumes
            ]
        );
    }

    /**
     * Affiche la section article dans la homepage
     *
     * @param PostRepository $postRepository
     *
     * @return Response
     */
    public function lastArticle(PostRepository $postRepository): Response
    {
        $articles = $postRepository->lastSection('article');
        $fourArticles = $postRepository->fourSection('article');

        return $this->render(
            'post/include/_section_article.html.twig',
            [
                'articles'=> $articles,
                'fourArticles'=> $fourArticles
            ]
        );
    }
}

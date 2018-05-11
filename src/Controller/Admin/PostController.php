<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 26/02/2018
 * Time: 10:55
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */

namespace App\Controller\Admin;


use App\Entity\Post;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class PostController
 *
 * @category PHP
 * @package  App\Controller\Admin
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class PostController extends AbstractController
{
    /**
     * Affiche tout les articles
     *
     * @param PostRepository $postRepository selectionne tout Post
     *
     * @Route("/admin/", name="admin_index")
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->allArticle();

        return $this->render(
            'admin/post/index.html.twig',
            [
                'posts' => $posts
            ]
        );
    }

    /**
     * Affiche un article
     *
     * @param Post $posts selectionne un Post
     *
     * @Route("/admin/post/{slug}", name="admin_show")
     *
     * @return Response
     */
    public function show(Post $posts): Response
    {
        return $this->render(
            'admin/post/show.html.twig',
            [
                'posts' => $posts
            ]
        );
    }
}

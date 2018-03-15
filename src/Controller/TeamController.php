<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 28/02/2018
 * Time: 14:38
 */

namespace App\Controller;


use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    /**
     * @Route("/atlanta", name="atlanta_team")
     */
    public function atlanta(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy(['tag'=>'atlanta']);
        return $this->render('post/team.html.twig', ['posts' => $posts,]);
    }

    /**
     * @Route("/boston", name="boston_team")
     */
    public function boston(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy(['tag'=>'boston']);
        return $this->render('post/team.html.twig', ['posts' => $posts,]);
    }
}
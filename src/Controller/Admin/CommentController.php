<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 01/05/2018
 * Time: 09:02
 */

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
class CommentController extends AbstractController
{
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
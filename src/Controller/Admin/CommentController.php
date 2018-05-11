<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 01/05/2018
 * Time: 09:02
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Repository\CommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CommentController
 *
 * @category PHP
 * @package  App\Controller\Admin
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class CommentController extends AbstractController
{
    /**
     * Affiche tous les commentaires
     *
     * @param CommentRepository $commentRepository sélectionne tout les commantaires
     *
     * @Route("/admin/comment", name="admin_index_comment")
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function indexComment(CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findAll();

        return $this->render(
            'admin/comment/index.html.twig',
            [
                'comments' => $comments
            ]
        );
    }

    /**
     * Affiche un seul commentaire avec tout les informations
     *
     * @param Comment $comment sélectionne tout les variables de comment
     *
     * @Route("/admin/comment/{id}", name="admin_show_comment")
     *
     * @return Response
     */
    public function showComment(Comment $comment): Response
    {
        return $this->render(
            'admin/comment/show.html.twig',
            [
                'comment' => $comment
            ]
        );
    }
}

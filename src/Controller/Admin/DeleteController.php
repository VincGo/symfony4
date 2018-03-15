<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 27/02/2018
 * Time: 11:24
 */

namespace App\Controller\Admin;


use App\Entity\Comment;
use App\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    /**
     * @Route("/{id}/delete", name="admin_delete")
     * @Method("POST")
     */
    public function delete(Request $request, Post $post): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash('success', "L'article a été supprimé.");

        return $this->redirectToRoute('admin_index');
    }

    /**
     * @Route("comment/{id}/delete", name="admin_delete_comment")
     * @Method("POST")
     */
    public function deleteComment(Request $request, Comment $comment): Response
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        $this->addFlash('success', "Le commentaire a été supprimé.");

        return $this->redirectToRoute('admin_index_comment');
    }
}
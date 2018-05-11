<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 27/02/2018
 * Time: 11:24
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
use App\Entity\Contact;
use App\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DeleteController
 *
 * @category PHP
 * @package  App\Controller\Admin
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class DeleteController extends AbstractController
{
    /**
     * Efface un article
     *
     * @param Request $request
     * @param Post    $post
     *
     * @Route("/{id}/delete", name="admin_delete")
     *
     * @Method("POST")
     *
     * @return Response
     */
    public function delete(Request $request, Post $post): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        $this->addFlash(
            'success',
            "L'article a été supprimé."
        );

        return $this->redirectToRoute('admin_index');
    }

    /**
     * Efface un commentaire
     *
     * @param Request $request
     * @param Comment $comment
     *
     * @Route("comment/{id}/delete", name="admin_delete_comment")
     *
     * @Method("POST")
     *
     * @return Response
     */
    public function deleteComment(Request $request, Comment $comment): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($comment);
        $em->flush();

        $this->addFlash(
            'success',
            "Le commentaire a été supprimé."
        );

        return $this->redirectToRoute('admin_index_comment');
    }

    /**
     * Efface un message contact
     *
     * @param Request $request
     * @param Contact $contact
     *
     * @Route("contact/{id}/delete", name="admin_delete_contact")
     *
     * @Method("POST")
     *
     * @return Response
     */
    public function deleteContact(Request $request, Contact $contact): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($contact);
        $em->flush();

        $this->addFlash(
            'success',
            "Le commentaire a été supprimé."
        );

        return $this->redirectToRoute('admin_index_contact');
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 29/01/2018
 * Time: 09:15
 */

namespace App\Controller;

use App\Events;
use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CommentController extends AbstractController
{
    /**
     * @param Request $request
     * @param Post $post
     * @param EventDispatcherInterface $eventDispatcher
     * @Route("/comment/{postSlug}/new", name="comment_new")
     * @Method("POST")
     * @ParamConverter("post", options={"mapping": {"postSlug": "slug"}})
     */
    public function commentNew(Request $request, Post $post, EventDispatcherInterface $eventDispatcher) :Response
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $post->addComment($comment);

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($comment);
            $em->flush();

            $event = new GenericEvent($comment);

            $eventDispatcher->dispatch(Events::COMMENT_CREATED, $event);
            return $this->redirectToRoute('blog_post', ['slug' => $post->getSlug()]);
        }

        return $this->render('post/comment_form_error.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }

    public function commentForm(Post $post): Response
    {
        $form = $this->createForm(CommentType::class);

        return $this->render('post/_comment_form.html.twig', [
            'post' => $post,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @param CommentRepository $commentRepository
     * @return Response
     * @Route("/comment", name="comment")
     */
    public function show(CommentRepository $commentRepository)
    {
        $x = new Comment();
        $x->getId();
        $comments = $commentRepository->findAll();
        $comments_by_id = [];

        foreach ($comments as $comment){
            $comments_by_id[$comment->$x] = $comment;
        }

        foreach ($comments as $k => $comment){
            if ($comment->parent_id != 0){
                $comments_by_id[$comment->parents_id]->children[] = $comment;
                unset($comments[$k]);
            }
        }
        return $this->render('comment.html.twig', ['comment' => $comments]);
    }
}
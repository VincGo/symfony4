<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 29/01/2018
 * Time: 09:15
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Handlers\Interfaces\CommentHandlerInterfaces;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CommentController extends AbstractController
{
    private $formFactory;
    private $commentHandlerInterfaces;

    public function __construct(
        FormFactoryInterface $formFactory,
        CommentHandlerInterfaces $commentHandlerInterfaces
    ){
        $this->formFactory = $formFactory;
        $this->commentHandlerInterfaces = $commentHandlerInterfaces;
    }


    /**
     * @param Request $request
     * @param Post $post
     * @Route("/comment/{postSlug}/new", name="comment_new")
     * @Method("POST")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @ParamConverter("post", options={"mapping": {"postSlug": "slug"}})
     */
    public function commentNew(Request $request, Post $post) :Response
    {
        $comment = new Comment();

        $form = $this->formFactory->create(CommentType::class, $comment)
                                  ->handleRequest($request);

        if($this->commentHandlerInterfaces->handle($form, $post)) {

            $this->addFlash('success', "Votre commentaire a bien été envoyé");

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

        return $this->render('post/include/_comment_form.html.twig', [
            'post' => $post,
            'form'=>$form->createView(),
        ]);
    }
}
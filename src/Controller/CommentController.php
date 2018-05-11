<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 29/01/2018
 * Time: 09:15
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Handlers\Interfaces\CommentHandlerInterfaces;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PHP version 7.1
 *
 * Class CommentController
 *
 * @category PHP
 * @package  App\Controller
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony
 */
class CommentController extends AbstractController
{
    private $_formFactory;
    private $_commentHandlerInterfaces;

    /**
     * CommentController constructor.
     *
     * @param FormFactoryInterface     $_formFactory
     * @param CommentHandlerInterfaces $_commentHandlerInterfaces
     */
    public function __construct(
        FormFactoryInterface $_formFactory,
        CommentHandlerInterfaces $_commentHandlerInterfaces
    ) {
        $this->_formFactory = $_formFactory;
        $this->_commentHandlerInterfaces = $_commentHandlerInterfaces;
    }


    /**
     * Gestion de nouveau comentaire
     *
     * @param Request $request
     * @param Post    $post
     *
     * @Route("/comment/{postSlug}/new", name="comment_new")
     *
     * @Method("POST")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @ParamConverter(
     *     "post",
     *      options={"mapping": {"postSlug": "slug"}}
     *     )
     *
     * @return Response
     */
    public function commentNew(Request $request, Post $post) :Response
    {
        $comment = new Comment();

        $form = $this->_formFactory->create(CommentType::class, $comment)
            ->handleRequest($request);

        if ($this->_commentHandlerInterfaces->handle($form, $post)) {
            $this->addFlash('success', "Votre commentaire a bien été envoyé");

            return $this->redirectToRoute('blog_post', ['slug' => $post->getSlug()]);
        }

        return $this->render(
            'post/comment_form_error.html.twig',
            [
                'post' => $post,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * Affichage du formulaire
     *
     * @param Post $post
     *
     * @return Response
     */
    public function commentForm(Post $post): Response
    {
        $form = $this->createForm(CommentType::class);

        return $this->render(
            'post/include/_comment_form.html.twig',
            [
                'post' => $post,
                'form'=>$form->createView(),
            ]
        );
    }
}

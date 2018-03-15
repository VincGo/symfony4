<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 27/02/2018
 * Time: 09:47
 */

namespace App\Controller\Admin;


use App\Entity\Post;
use App\Form\CreateType;
use App\Utils\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends AbstractController

{

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/new", name="admin_new")
     */
    public function new(Request $request): Response
    {
        $post = new Post();

        // See https://symfony.com/doc/current/book/forms.html#submitting-forms-with-multiple-buttons
        $form = $this->createForm(CreateType::class, $post);

        $form->handleRequest($request);

        // the isSubmitted() method is completely optional because the other
        // isValid() method already checks whether the form is submitted.
        // However, we explicitly add it to improve code readability.
        // See https://symfony.com/doc/current/best_practices/forms.html#handling-form-submits
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug(Slugger::slugify($post->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            // Flash messages are used to notify the user about the result of the
            // actions. They are deleted automatically from the session as soon
            // as they are accessed.
            // See https://symfony.com/doc/current/book/controller.html#flash-messages
            $this->addFlash('success', "L'article a bien été enregistré");

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
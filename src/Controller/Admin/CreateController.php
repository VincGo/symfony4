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

        $form = $this->createForm(CreateType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug(Slugger::slugify($post->getTitle()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            $this->addFlash('success', "L'article a bien été enregistré");

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
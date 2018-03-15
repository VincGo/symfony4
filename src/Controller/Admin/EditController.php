<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 27/02/2018
 * Time: 13:20
 */

namespace App\Controller\Admin;


use App\Entity\Post;
use App\Form\CreateType;
use App\Utils\Slugger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    /**
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_edit")
     * @Method({"GET", "POST"})
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(CreateType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug(Slugger::slugify($post->getTitle()));
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', "L'article a bien été modifié");

            return $this->redirectToRoute('admin_edit', ['id' => $post->getId()]);
        }

        return $this->render('admin/post/edit.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
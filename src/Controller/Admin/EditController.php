<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 27/02/2018
 * Time: 13:20
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4 
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

/**
 * Class EditController
 *
 * @category PHP
 * @package  App\Controller\Admin
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class EditController extends AbstractController
{
    /**
     * Edit un article
     *
     * @param Request $request
     * @param Post    $post
     *
     * @Route("/{id}/edit", requirements={"id": "\d+"}, name="admin_edit")
     *
     * @Method({"GET", "POST"})
     *
     * @return Response
     */
    public function edit(Request $request, Post $post): Response
    {
        $form = $this->createForm(CreateType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post->setSlug(Slugger::slugify($post->getTitle()));
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                "L'article a bien été modifié"
            );

            return $this->redirectToRoute('admin_index');
        }

        return $this->render(
            'admin/post/edit.html.twig',
            [
                'post' => $post,
                'form' => $form->createView(),
            ]
        );
    }
}

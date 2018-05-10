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
use App\Handlers\Interfaces\CreateHandlerInterfaces;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreateController extends AbstractController

{
    private $formFactory;
    private $createHandler;

    public function __construct(
        FormFactoryInterface $formFactory,
        CreateHandlerInterfaces $createHandler
    ){
        $this->formFactory = $formFactory;
        $this->createHandler = $createHandler;
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/admin/new", name="admin_new")
     */
    public function new(Request $request): Response
    {
        $post = new Post();

        $form = $this->formFactory->create(CreateType::class, $post)
                                  ->handleRequest($request);

        if ($this->createHandler->handle($form)) {
            $this->addFlash('success', "L'article a bien été enregistré");

            return $this->redirectToRoute('admin_index');
        }

        return $this->render('admin/post/new.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 27/02/2018
 * Time: 09:47
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
use App\Handlers\Interfaces\CreateHandlerInterfaces;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CreateController
 *
 * @category PHP
 * @package  App\Controller\Admin
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class CreateController extends AbstractController
{
    private $_formFactory;
    private $_createHandler;

    /**
     * CreateController constructor.
     *
     * @param FormFactoryInterface    $_formFactory
     * @param CreateHandlerInterfaces $_createHandler
     */
    public function __construct(
        FormFactoryInterface $_formFactory,
        CreateHandlerInterfaces $_createHandler
    ) {
        $this->_formFactory = $_formFactory;
        $this->_createHandler = $_createHandler;
    }

    /**
     * Création d'un nouvel article
     *
     * @param Request $request
     *
     * @Route("/admin/new", name="admin_new")
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $post = new Post();

        $form = $this->_formFactory->create(CreateType::class, $post)
            ->handleRequest($request);

        if ($this->_createHandler->handle($form)) {
            $this->addFlash(
                'success',
                "L'article a bien été enregistré"
            );

            return $this->redirectToRoute('admin_index');
        }

        return $this->render(
            'admin/post/new.html.twig',
            [
                'post' => $post,
                'form' => $form->createView(),
            ]
        );
    }
}

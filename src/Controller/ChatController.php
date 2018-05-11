<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 18/04/2018
 * Time: 09:07
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Tag;
use App\Form\ChatType;
use App\Handlers\Interfaces\ChatHandlerInterfaces;
use App\Repository\ChatRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * PHP version 7.1
 *
 * Class ChatController
 *
 * @category PHP
 * @package  App\Controller
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class ChatController extends AbstractController
{
    private $_formFactory;
    private $_chatHandlerInterfaces;

    /**
     * ChatController constructor.
     *
     * @param FormFactoryInterface  $_formFactory
     * @param ChatHandlerInterfaces $_chatHandlerInterfaces
     */
    public function __construct(
        FormFactoryInterface $_formFactory,
        ChatHandlerInterfaces $_chatHandlerInterfaces
    ) {
        $this->_formFactory = $_formFactory;
        $this->_chatHandlerInterfaces = $_chatHandlerInterfaces;
    }

    /**
     * Gestion d'envoie de message pour le chat.
     *
     * @param Request $request
     * @param Tag     $tag
     *
     * @Route("/chat/new/{tag}", name="new_msg")
     *
     * @Method("POST")
     *
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     *
     * @ParamConverter(
     *     "tag",
     *     options={"mapping": {"tag": "name"}}
     *     )
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function sendMsg(Request $request, Tag $tag): Response
    {
        $test = new Chat();
        $form = $this->_formFactory->create(ChatType::class, $test)
            ->handleRequest($request);

        $this->_chatHandlerInterfaces->handle($form, $tag);

        return $this->render(
            'post/include/_send_msg.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
            ]
        );
    }

    /**
     * Envoie de données lors du rafraichissment via JS
     *
     * @param $id
     * @param Tag            $tag            Récupère le tag de la team
     * @param ChatRepository $chatRepository On récupère les derniers messages
     *
     * @Route("/chat/{tag}/refresh/{id}", name="refresh_msg")
     *
     * @ParamConverter("tag", options={"mapping": {"tag": "name"}})
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function refreshMsg($id, Tag $tag, ChatRepository $chatRepository)
    {
        $refreshMsgs = $chatRepository->findLastMsg($id, $tag);

        return $this->render(
            'post/refresh_msg.html.twig',
            [
                'refreshMsgs' => $refreshMsgs
            ]
        );
    }
}

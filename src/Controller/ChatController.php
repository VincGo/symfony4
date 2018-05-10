<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 18/04/2018
 * Time: 09:07
 */

namespace App\Controller;

use App\Entity\Chat;
use App\Entity\Tag;
use App\Form\ChatType;
use App\Handlers\Interfaces\ChatHandlerInterfaces;
use App\Repository\ChatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class ChatController extends AbstractController
{
    private $formFactory;
    private $chatHandlerInterfaces;

    public function __construct(
        FormFactoryInterface $formFactory,
        ChatHandlerInterfaces $chatHandlerInterfaces
    ){
        $this->formFactory = $formFactory;
        $this->chatHandlerInterfaces = $chatHandlerInterfaces;
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/chat/new/{tag}", name="new_msg")
     * @Method("POST")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @ParamConverter("tag", options={"mapping": {"tag": "name"}})
     */
    public function sendMsg(Request $request, Tag $tag)
    {
        $test = new Chat();
        $form = $this->formFactory->create(ChatType::class, $test)
                                  ->handleRequest($request);

        $this->chatHandlerInterfaces->handle($form, $tag);

        return $this->render('post/include/_send_msg.html.twig', [
            'tag' => $tag,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/chat/{tag}/refresh/{id}", name="refresh_msg")
     * @ParamConverter("tag", options={"mapping": {"tag": "name"}})
     * @Method("GET")
     */
    public function refreshMsg($id,Tag $tag,ChatRepository $chatRepository)
    {
        $refreshMsgs = $chatRepository->findLastMsg($id, $tag);

        return $this->render('post/refresh_msg.html.twig', ['refreshMsgs' => $refreshMsgs]);
    }
}
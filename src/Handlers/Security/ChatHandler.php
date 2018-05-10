<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 07/05/2018
 * Time: 14:23
 */

namespace App\Handlers\Security;

use App\Entity\Tag;
use App\Handlers\Interfaces\ChatHandlerInterfaces;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

class ChatHandler extends AbstractController implements ChatHandlerInterfaces
{
    private $entityManager;

    public function __construct(
     EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

    /**
     * @param FormInterface $form
     * @param Tag $tag
     * @return bool
     * @ParamConverter("tag", options={"mapping": {"tag": "name"}})
     */
    public function handle(FormInterface $form, Tag $tag): bool
    {
        if($form->isSubmitted() && $form->isValid())
        {
            $chat = $form->getData();
            $chat->setPseudo($this->getUser());
            $chat->setTeam($tag);
            $this->entityManager->persist($chat);
            $this->entityManager->flush();

            return true;
        }

        return false;

    }
}
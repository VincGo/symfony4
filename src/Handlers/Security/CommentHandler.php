<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 09/05/2018
 * Time: 10:00
 */

namespace App\Handlers\Security;


use App\Entity\Post;
use App\Handlers\Interfaces\CommentHandlerInterfaces;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

class CommentHandler extends AbstractController implements CommentHandlerInterfaces
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

    public function handle(FormInterface $form, Post $post): bool
    {
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData();
            $comment->setAuthor($this->getUser());
            $post->addComment($comment);
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}
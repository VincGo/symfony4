<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 09/05/2018
 * Time: 14:16
 */

namespace App\Handlers\Security;


use App\Handlers\Interfaces\ContactHandlerInterfaces;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;

class ContactHandler implements ContactHandlerInterfaces
{
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
    }

    public function handle(FormInterface $form): bool
    {
        if($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}
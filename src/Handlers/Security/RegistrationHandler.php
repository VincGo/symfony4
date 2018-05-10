<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 02/05/2018
 * Time: 14:21
 */

namespace App\Handlers\Security;


use App\Handlers\Interfaces\RegistrationHandlerInterfaces;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationHandler implements RegistrationHandlerInterfaces
{
    private $passwordEncoder;

    private $entityManager;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    ){
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManager = $entityManager;
    }

    public function handle(FormInterface $form): bool
    {
        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            $user->setRoles(array('ROLE_USER'));

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return true;
        }
        return false;
    }
}
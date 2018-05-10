<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 09/05/2018
 * Time: 14:34
 */

namespace App\Handlers\Security;


use App\Handlers\Interfaces\CreateHandlerInterfaces;
use App\Utils\Slugger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;

class CreateHandler extends AbstractController implements CreateHandlerInterfaces
{
    private $entitymanager;

    public function __construct(
        EntityManagerInterface $entityManager
    ){
        $this->entitymanager = $entityManager;
    }

    public function handle(FormInterface $form): bool
    {
        if($form->isSubmitted() && $form->isValid()) {
            $new = $form->getData();
            $new->setSlug(Slugger::slugify($new->getTitle()));
            $this->entitymanager->persist($new);
            $this->entitymanager->flush();

            return true;
        }

        return false;
    }
}
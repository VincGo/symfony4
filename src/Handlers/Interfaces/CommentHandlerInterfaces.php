<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 09/05/2018
 * Time: 09:55
 */

namespace App\Handlers\Interfaces;


use App\Entity\Post;
use Symfony\Component\Form\FormInterface;

interface CommentHandlerInterfaces
{
    /**
     * @param FormInterface $form
     * @return bool
     */
    public function handle(FormInterface $form, Post $post): bool;
}
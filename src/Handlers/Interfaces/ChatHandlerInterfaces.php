<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 07/05/2018
 * Time: 14:16
 */

namespace App\Handlers\Interfaces;


use App\Entity\Tag;
use Symfony\Component\Form\FormInterface;

interface ChatHandlerInterfaces
{
    /**
     * @param FormInterface $form
     * @return bool
     */
    public function handle(FormInterface $form, Tag $tag): bool;
}
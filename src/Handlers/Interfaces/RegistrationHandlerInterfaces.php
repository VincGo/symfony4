<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 02/05/2018
 * Time: 14:23
 */

namespace App\Handlers\Interfaces;


use Symfony\Component\Form\FormInterface;

interface RegistrationHandlerInterfaces
{
    /**
     * @param FormInterface $form
     * @return bool
     */
    public function handle(FormInterface $form): bool;
}
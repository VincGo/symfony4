<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 09/05/2018
 * Time: 14:14
 */

namespace App\Handlers\Interfaces;

use Symfony\Component\Form\FormInterface;

interface ContactHandlerInterfaces
{
    public function handle(FormInterface $form): bool;
}
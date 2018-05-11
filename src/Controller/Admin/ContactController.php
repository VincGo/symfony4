<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 01/05/2018
 * Time: 08:46
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */

namespace App\Controller\Admin;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ContactController
 *
 * @category PHP
 * @package  App\Controller\Admin
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
 */
class ContactController extends AbstractController
{
    /**
     * Affiche tout les messages de contact
     *
     * @param ContactRepository $contactRepository selectionne tout les Contact
     *
     * @Route("admin/contact", name="admin_index_contact")
     *
     * @Method("GET")
     *
     * @return Response
     */
    public function indexContact(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();

        return $this->render(
            'admin/contact/index.html.twig',
            [
                'contacts' => $contacts
            ]
        );
    }

    /**
     * Affiche un contact
     *
     * @param Contact $contact selectionne tout les information sur un contact
     *
     * @Route("admin/contact/{id}", name="admin_show_contact")
     *
     * @return Response
     */
    public function showContact(Contact $contact)
    {
        return $this->render(
            'admin/contact/show.html.twig',
            [
                'contact' => $contact
            ]
        );
    }
}

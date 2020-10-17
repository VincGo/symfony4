<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 01/05/2018
 * Time: 08:46
 */

namespace App\Controller\Admin;




use App\Entity\Contact;
use App\Repository\ContactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends AbstractController
{
    /**
     * @Route("admin/contact", name="admin_index_contact")
     * @Method("GET")
     */
    public function indexContact(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();

        return $this->render('admin/contact/index.html.twig', ['contacts' => $contacts]);
    }

    /**
     * @Route("admin/contact/{id}", name="admin_show_contact")
     */
    public function showContact(Contact $contact)
    {
        return $this->render('admin/contact/show.html.twig', ['contact' => $contact]);
    }
}
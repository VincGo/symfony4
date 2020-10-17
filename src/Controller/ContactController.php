<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 29/01/2018
 * Time: 09:18
 */

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/contact", name="contact_post")
     */
    public function contact(Request $request, EntityManagerInterface $em)
    {
        $contact = new Contact();
        $formCont = $this->createForm(ContactType::class, $contact);
        $formCont->handleRequest($request);
        if ($formCont->isSubmitted() &&  $formCont->isValid())
        {
            $contact = $formCont->getData();
            $em->persist($contact);
            $em->flush();

            $this->addFlash('success', 'Merci de nous avoir contacté. Nous vous répondrons dès que possible.');

            return $this->redirectToRoute('list_post');
        }
        return $this->render('contact/form_contact.html.twig', ['formCont'=>$formCont->createView(),]);
    }
}
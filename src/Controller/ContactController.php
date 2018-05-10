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
use App\Handlers\Interfaces\ContactHandlerInterfaces;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    private $formFactory;
    private $contactHandlerInterfaces;

    public function __construct(
        FormFactoryInterface $formFactory,
        ContactHandlerInterfaces $contactHandlerInterfaces
    ){
        $this->formFactory = $formFactory;
        $this->contactHandlerInterfaces = $contactHandlerInterfaces;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/contact", name="contact_post")
     */
    public function contact(Request $request, EntityManagerInterface $em)
    {
        $contact = new Contact();
        $formCont = $this->formFactory->create(ContactType::class, $contact)
                                      ->handleRequest($request);

        if($this->contactHandlerInterfaces->handle($formCont)) {

            $this->addFlash('success', 'Merci de nous avoir contacté. Nous vous répondrons dès que possible.');

            return $this->redirectToRoute('list_post');

        }

        return $this->render('contact/form_contact.html.twig', ['formCont'=>$formCont->createView(),]);
    }
}
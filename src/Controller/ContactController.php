<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 29/01/2018
 * Time: 09:18
 *
 * PHP version 7.1
 *
 * @category PHP
 * @package  Myprojectlocale
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony4
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

/**
 * Class ContactController
 *
 * @category PHP
 * @package  App\Controller
 * @author   Vincent <tazuku.66@gmail.com>
 * @link     https://github.com/VincGo/symfony
 */
class ContactController extends AbstractController
{
    private $_formFactory;
    private $_contactHandlerInterfaces;

    /**
     * ContactController constructor.
     *
     * @param FormFactoryInterface     $_formFactory
     * @param ContactHandlerInterfaces $_contactHandlerInterfaces
     */
    public function __construct(
        FormFactoryInterface $_formFactory,
        ContactHandlerInterfaces $_contactHandlerInterfaces
    ) {
        $this->_formFactory = $_formFactory;
        $this->_contactHandlerInterfaces = $_contactHandlerInterfaces;
    }

    /**
     * Gestion de l'envoie de message de contact.
     *
     * @param Request $request
     *
     * @Route("/contact", name="contact_post")
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function contact(Request $request)
    {
        $contact = new Contact();
        $formCont = $this->_formFactory->create(ContactType::class, $contact)
            ->handleRequest($request);

        if ($this->_contactHandlerInterfaces->handle($formCont)) {

            $this->addFlash(
                'success',
                'Merci de nous avoir contacté. 
                Nous vous répondrons dès que possible.'
            );

            return $this->redirectToRoute('list_post');

        }

        return $this->render(
            'contact/form_contact.html.twig',
            [
                'formCont'=>$formCont->createView()
            ]
        );
    }
}

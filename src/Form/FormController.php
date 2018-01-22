<?php

namespace App\Form;
use App\Entity\Contact;
use App\Entity\Posts;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class FormController extends AbstractController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function PostForm(Request $request)
    {
        $post = new Posts();

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
        }
    }

    public function ContactForm(Request $request)
    {
        $contact = new Contact();

        $formCont = $this->createFormBuilder($contact)
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('subject', TextType::class)
            ->add('message', TextType::class)
            ->getForm();

        $formCont->handleRequest($request);

        if($formCont->isSubmitted() && $formCont->isValid())
        {
            $contact = $formCont->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
        }
    }
}
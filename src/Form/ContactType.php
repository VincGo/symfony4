<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 17/01/2018
 * Time: 14:38
 */

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom'
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'E-mail'
                ]
            )
            ->add(
                'subject',
                TextType::class,
                [
                    'label' => 'Sujet'
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'label' => 'Message'
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class
        ]);
    }
}

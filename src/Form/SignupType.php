<?php
/**
 * Created by PhpStorm.
 * User: vincent
 * Date: 01/02/2018
 * Time: 07:45
 */

namespace App\Form;


use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignupType extends AbstractType
{
    public function buildForm(FormBuilderInterface$builder, array $options)
    {
        $builder
            ->add('fullName', TextType::class, array('label' => 'Nom complet'))
            ->add('username', TextType::class, array('label' => 'Pseudo'))
            ->add('email', EmailType::class, array('label' => 'E-mail'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Créez un mot de passe'),
                'second_options' => array('label' => 'Confirmez votre mot de passe')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
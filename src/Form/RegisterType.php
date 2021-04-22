<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => "Nom",
                'attr' => [
                    'placeholder' => "Saisissez votre nom"
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => "Prenom",
                'attr' => [
                    'placeholder' => "Saisissez votre prenom"
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => "Adresse electronique",
                'attr' => [
                    'placeholder' => "Saisissez votre email"
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message'=>'Le mot de passe est la confirmation doivent etre identique.',
                'required'=>true,
                'label' => "Mot de passe",
                'first_options' => [
                    'label'=>'Mot de passe',
                    'attr'=>[
                        'placeholder' =>'Merci de saisir votre mot de passe'
                    ]
                ],
                'second_options' => [
                    'label'=>'Confirmation',
                    'attr'=>[
                        'placeholder' =>'Merci de confirmer votre mot de passe'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

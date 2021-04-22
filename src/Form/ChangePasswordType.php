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

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon Adresse email'
            ])
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon nom'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon prenom'
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped'=>false,
                'attr' => [
                    'placeholder' => "Votre mot de passe actuel"
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le mot de passe est la confirmation doivent etre identique.',
                'required' => true,
                'label' => "Nouveau mot de passe",
                'first_options' => [
                    'label' => 'Nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Merci de saisir votre  nouveau mot de passe'
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmation',
                    'constraints' => new EqualTo('first_option'),
                    'attr' => [
                        'placeholder' => 'Merci de confirmer votre nouveau mot de passe'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => "Mettre a jour"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

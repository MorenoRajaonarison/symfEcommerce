<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label'=>"Nom de l'adresse",
                'attr'=>[
                    "placeholder"=>"Nommez votre adresse"
                ]
            ])
            ->add('firstname',TextType::class,[
                'label'=>"Nom",
                'attr'=>[
                    "placeholder"=>"Entrez votre nom"
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>"Prenom",
                'attr'=>[
                    "placeholder"=>"Entrez votre prenom"
                ]
            ])
            ->add('company',TextType::class,[
                'label'=>"Societé",
                'attr'=>[
                    "placeholder"=>"Entrez votre societé"
                ]
            ])
            ->add('address',TextType::class,[
                'label'=>"Adresse",
                'attr'=>[
                    "placeholder"=>"Entrez votre adresse"
                ]
            ])
            ->add('postal',TextType::class,[
                'label'=>"Code Postal",
                'attr'=>[
                    "placeholder"=>"Entrez votre code postal"
                ]
            ])
            ->add('city',TextType::class,[
                'label'=>"Ville",
                'attr'=>[
                    "placeholder"=>"Entrez votre ville"
                ]
            ])
            ->add('country',CountryType::class,[
                'label'=>"Pays",
                'attr'=>[
                    "placeholder"=>"Entrez votre pays"
                ]
            ])
            ->add('phone',TelType::class,[
                'label'=>"Contact",
                'attr'=>[
                    "placeholder"=>"Entrez votre numeros de telephone"
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>"Valider",
                'attr'=>[
                    'class'=>'btn-block btn-info'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}

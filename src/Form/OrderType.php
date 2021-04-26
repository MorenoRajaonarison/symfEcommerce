<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adresses', EntityType::class,[
                'label'=>"Adresse de livraison",
                'required'=>true,
                'class'=>Address::class,
                'choices'=>$options['user']->getAddresses(),
                'multiple'=>false,
                'expanded'=>true
            ])
            ->add('carriers', EntityType::class,[
                'label'=>"Transporteur",
                'required'=>true,
                'class'=>Carrier::class,
                'multiple'=>false,
                'expanded'=>true
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Valider ma commande',
                'attr'=>[
                    'class'=>'btn btn-info btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
            'user'=>array()
        ]);
    }
}

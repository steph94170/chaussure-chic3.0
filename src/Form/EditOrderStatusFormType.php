<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Order;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;

class EditOrderStatusFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', ChoiceType::class, [
                'choices'  => [
                    'Valider la commande' =>"commande validée",
                ],
                'placeholder' => "Modifier le statut de la commandes",
                
                'constraints' =>[
                    new NotBlank([
                        'message'=>"Le statut est obligatoire."
                        
                    ]),
                    new Length([
                        'max'=> 255,
                        'maxMessage'=>"Le statut doit contenir au maximum 255 caractères."
                        
                    ])
                ]
            ])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}

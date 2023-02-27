<?php

namespace App\Form;

use App\Entity\Availability;
use App\Entity\Reservations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('reservationDate', DateType::class,[
            'widget' => 'single_text',
            'label' => 'Date de reservation',
        ])
        ->add('availability', EntityType::class, [
            'class' => Availability::class,
            'placeholder' => 'Date selectionnée',
            'label' => false,
            'attr' => [
                'style' => 'display:none'
            ]
        ])
        ->add('slot', ChoiceType::class, [
            'label' => 'Créneaux horaires',
            'placeholder' => 'Choisir un creneau',
                'choices' => [
                    'Midi' => [
                        '12:00 - 12:15' => '12:00 - 12:15',
                        '12:15 - 12:30' => '12:15 - 12:30',
                        '12:30 - 12:45' => '12:30 - 12:45',
                        '12:45 - 13:00' => '12:45 - 13:00',
                        '13:00 - 13:15' => '13:00 - 13:15',
                        '13:15 - 13:30' => '13:15 - 13:30',
                    ],
                    'Soir' => [
                        '19:00 - 19:15' => '19:00 - 19:15',
                    '19:15 - 19:30' => '19:15 - 19:30',
                    '19:30 - 19:45' => '19:30 - 19:45',
                    '19:45 - 20:00' => '19:45 - 20:00',
                    '20:00 - 20:15' => '20:00 - 20:15',
                    '20:15 - 20:30' => '20:15 - 20:30',
                    '20:30 - 20:45' => '20:30 - 20:45',
                    '20:45 - 21:00' => '20:45 - 21:00',
                    ],    
                ],

        ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-info'
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservations::class,
        ]);
    }
}

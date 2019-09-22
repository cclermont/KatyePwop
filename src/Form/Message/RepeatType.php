<?php

namespace App\Form\Message;

use App\Entity\Message\Repeat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RepeatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $every = [];
        for ($i=1; $i < 1000; $i++) { 
            $every[$i] = $i;
        }

        $months = [];
        for ($i=1; $i < 32; $i++) { 
            $months[$i] = $i;
        }
        $builder
            ->add('frequency', ChoiceType::class, [
                'choices' => [
                    'Chaque jour' => 'daily',
                    'Chaque semaine' => 'weekly',
                    'Chaque mois' => 'monthly',
                    'Chaque année' => 'yearly',
                ],
                'required' => false,
                'placeholder' => 'Choisissez une optioin',
            ])
            ->add('every', ChoiceType::class, [
                'choices' => $every,
                'required' => false,
            ])
            ->add('weekDays', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'Dimanche' => 'sunday',
                    'Lundi' => 'monday',
                    'Mardi' => 'thusday',
                    'Mercredi' => 'wednersday',
                    'Jeudi' => 'thursday',
                    'Vendredi' => 'friday',
                    'Samedi' => 'saturday',
                ],
                'required' => false,
            ])
            ->add('monthDays', ChoiceType::class, [
                'multiple' => true,
                'choices' => $months,
                'required' => false,
            ])
            ->add('yearMonths', ChoiceType::class, [
                'multiple' => true,
                'choices' => [
                    'Janvier' => 'junuary',
                    'Fevrier' => 'february',
                    'Mars' => 'march',
                    'Avril' => 'april',
                    'Mai' => 'may',
                    'Juin' => 'june',
                    'Juillet' => 'july',
                    'Aout' => 'august',
                    'Septembre' => 'september',
                    'Octobre' => 'october',
                    'Novembre' => 'november',
                    'Decembre' => 'december',
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repeat::class,
        ]);
    }
}

<?php

namespace App\Form\Message;

use App\Entity\Message\Schedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\Location\Location;
use App\Repository\Location\LocationRepository;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('time')
            ->add('day', ChoiceType::class, [
                'multiple' => false,
                'choices' => [
                    'Dimanche' => 'sunday',
                    'Lundi' => 'monday',
                    'Mardi' => 'thusday',
                    'Mercredi' => 'wednersday',
                    'Jeudi' => 'thursday',
                    'Vendredi' => 'friday',
                    'Samedi' => 'saturday',
                ],
                'required' => true,
                'placeholder' => "Choisissez un jour",
            ])
            ->add('location', EntityType::class, [
                'multiple' => false,
                'required' => true,
                'class' => Location::class,
                'choice_label' => 'fullname',
                'placeholder' => 'Choisissez une location',
                'query_builder' => function (LocationRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.fullname', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}

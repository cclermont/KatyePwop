<?php

namespace App\Form\User;

use App\Entity\User\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('birthdate')
            ->add('gender', ChoiceType:: class, [
                'placeholder' => 'Choisissez un sexe',
                'choices' => [
                    'Male' => Profile::GENDER_MALE,
                    'Female' => Profile::GENDER_FEMALE,
                ],
            ])
            ->add('image', ImageType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
        ]);
    }
}

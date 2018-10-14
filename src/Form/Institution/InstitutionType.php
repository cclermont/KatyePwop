<?php

namespace App\Form\Institution;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\User\User;
use App\Entity\Location\Location;
use App\Entity\Institution\Institution;
use App\Repository\User\UserRepository;
use App\Repository\Location\LocationRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class InstitutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('enabled')
            ->add('brand', ImageType::class)
            ->add('type', ChoiceType:: class, [
                'placeholder' => 'Choisissez un type',
                'choices' => [
                    'Privée' => Institution::TYPE_PRIVATE,
                    'Gouvernementale' => Institution::TYPE_GOVERNMENTAL,
                ],
            ])
            ->add('place', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'fullname',
                'placeholder' => 'Choisissez un lieu',
                'query_builder' => function (LocationRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.fullname', 'ASC');
                },
            ])
            ->add('admin', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
                'placeholder' => 'Choisissez un administrateur',
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.username', 'ASC');
                },
            ])
            ->add('members', EntityType::class, [
                'multiple' => true,
                'class' => User::class,
                'choice_label' => 'username',
                'placeholder' => 'Choisissez les membres',
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.username', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Institution::class,
        ]);
    }
}

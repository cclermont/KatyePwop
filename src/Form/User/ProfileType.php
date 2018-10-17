<?php

namespace App\Form\User;

use App\Entity\User\Profile;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;

use App\Entity\Location\Location;
use App\Repository\Location\LocationRepository;

class ProfileType extends AbstractType
{
    /**
     * Conts
     */ 
    const API_CONTEXT = 'api';
    const ADMIN_CONTEXT = 'admin';
    const SUPER_ADMIN_CONTEXT = 'super_admin';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $context = $options['context'];
        $currentYear = (new \DateTime())->format('Y');

        $builder
            ->add('phone')
            ->add('firstname')
            ->add('lastname')
            ->add('birthdate', BirthdayType::class, [
                'widget' => self::API_CONTEXT == $context ? 'single_text' : 'choice',
                'format' => self::API_CONTEXT == $context ? 'yyyy-MM-dd' : \IntlDateFormatter::MEDIUM,
                'years' => range($currentYear - Profile::MAX_YEAR_OLD, $currentYear - Profile::MIN_YEAR_OLD),
            ])
            ->add('gender', ChoiceType:: class, [
                'placeholder' => 'Choisissez un sexe',
                'choices' => [
                    'Male' => Profile::GENDER_MALE,
                    'Female' => Profile::GENDER_FEMALE,
                ],
            ])
            ->add('image', ImageType::class)
        ;

        if (self::API_CONTEXT == $context) {
            
            $builder->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'fullname',
                'placeholder' => 'Choisissez un lieu',
                'query_builder' => function (LocationRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.fullname', 'ASC');
                },
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profile::class,
            'context' => self::SUPER_ADMIN_CONTEXT,
        ]);
    }
}

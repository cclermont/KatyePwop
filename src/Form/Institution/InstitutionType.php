<?php

namespace App\Form\Institution;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\User\User;
use App\Form\User\UserType;
use App\Entity\Location\Location;
use App\Form\Location\LocationMinType;
use App\Entity\Institution\Institution;
use App\Repository\User\UserRepository;
use App\Repository\Location\LocationRepository;

class InstitutionType extends AbstractType
{
    
    /**
     * Conts
     */ 
    const ADMIN_CONTEXT = 'admin';
    const SUPER_ADMIN_CONTEXT = 'super_admin';


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $admins = $options['admins'];
        $context = $options['context'];
        $members = $options['members'];

        $builder
            ->add('name')
            ->add('enabled', null, [
                'disabled' => self::ADMIN_CONTEXT == $context,
            ])
            ->add('allLocationAccess', null, [
                'disabled' => self::ADMIN_CONTEXT == $context,
            ])
            ->add('image', ImageType::class)
            ->add('type', ChoiceType::class, [
                'placeholder' => 'Choisissez un type',
                'disabled' => self::ADMIN_CONTEXT == $context,
                'choices' => [
                    'Privée' => Institution::TYPE_PRIVATE,
                    'Gouvernementale' => Institution::TYPE_GOVERNMENTAL,
                ],
            ])
            ->add('admin', UserType::class, [])
        ;

        if (self::SUPER_ADMIN_CONTEXT == $context) {
            $builder
                ->add('brandingColor', ColorType::class)
            ;
        }

        if (self::ADMIN_CONTEXT == $context) {
            $builder
                ->add('phone')
                ->add('email')
                ->add('slogan')
                ->add('website')
                ->add('address', LocationMinType::class)
                ->add('mayor', PersonType::class)
                ->remove('admin')
                ->remove('allLocationAccess')
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'admins' => [],
            'members' => [],
            'data_class' => Institution::class,
            'context' => self::SUPER_ADMIN_CONTEXT,
        ]);
    }
}

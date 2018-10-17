<?php

namespace App\Form\Institution;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Entity\User\User;
use App\Entity\Location\Location;
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
            ->add('image', ImageType::class)
            ->add('type', ChoiceType:: class, [
                'placeholder' => 'Choisissez un type',
                'disabled' => self::ADMIN_CONTEXT == $context,
                'choices' => [
                    'Privée' => Institution::TYPE_PRIVATE,
                    'Gouvernementale' => Institution::TYPE_GOVERNMENTAL,
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'fullname',
                'placeholder' => 'Choisissez un lieu',
                'disabled' => self::ADMIN_CONTEXT == $context,
                'query_builder' => function (LocationRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.fullname', 'ASC');
                },
            ])
            ->add('admin', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'formLabel',
                'placeholder' => 'Choisissez un administrateur',
                'query_builder' => function (UserRepository $er) use ($admins){
                    
                    $qb = $er->createQueryBuilder('u');

                    if (count($admins) > 0) {
                        $qb->where($qb->expr()->in('u.id', $admins));
                    }
                    
                    return $qb->orderBy('u.username', 'ASC');
                },
            ])
            ->add('members', EntityType::class, [
                'multiple' => true,
                'class' => User::class,
                'required' => false,
                'choice_label' => 'formLabel',
                'placeholder' => 'Choisissez les membres',
                'disabled' => self::ADMIN_CONTEXT == $context,
                'query_builder' => function (UserRepository $er) use ($members){
                    
                    $qb = $er->createQueryBuilder('u');

                    if (count($members) > 0) {
                        $qb->where($qb->expr()->in('u.id', $members));
                    }
                    
                    return $qb->orderBy('u.username', 'ASC');
                },
            ])
        ;
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

<?php

namespace App\Form\Message;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

use App\Entity\User\User;
use App\Entity\Message\Message;
use App\Entity\Location\Location;
use App\Repository\User\UserRepository;
use App\Repository\Location\LocationRepository;

class MessageType extends AbstractType
{
    private $user;
    
    /**
     * Conts
     */ 
    const API_CONTEXT = 'api';
    const ADMIN_CONTEXT = 'admin';
    const SUPER_ADMIN_CONTEXT = 'super_admin';

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $context = $options['context'];
        $institution = $options['institution'];

        $builder
            ->add('title')
            ->add('content')
            ->add('receivers', EntityType::class, [
                'multiple' => true,
                'required' => false,
                'class' => User::class,
                'choice_label' => 'username',
                'placeholder' => 'Choisissez les recepteurs',
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u')->orderBy('u.username', 'ASC');
                },
            ])
            ->add('images', CollectionType::class, [
                'allow_add' => true,
                'required' => false,
                'by_reference' => false,
                'entry_type' => ImageType::class,
            ])
        ;

        if (self::ADMIN_CONTEXT == $context && null != $institution) {
            $builder
                ->add('locations', EntityType::class, [
                    'multiple' => true,
                    'required' => false,
                    'class' => Location::class,
                    'choice_label' => 'fullname',
                    'placeholder' => 'Choisissez les locations',
                    'query_builder' => function (LocationRepository $er) use ($institution) {
                        return $er->createQueryBuilder('u')
                            ->innerJoin('u.institution', 'i')
                            ->addSelect('i')
                            ->where('i.id = :id')
                            ->setParameter('id', $institution->getId())
                            ->orderBy('u.fullname', 'ASC');
                    },
                ])
            ;
        }

        if (self::SUPER_ADMIN_CONTEXT == $context) {
            $builder
                ->add('locations', EntityType::class, [
                    'multiple' => true,
                    'required' => false,
                    'class' => Location::class,
                    'choice_label' => 'fullname',
                    'placeholder' => 'Choisissez les locations',
                    'query_builder' => function (LocationRepository $er) {
                        return $er->createQueryBuilder('u')->orderBy('u.fullname', 'ASC');
                    },
                ])
            ;
        }

        // if ($this->user->isSuperAdmin() || $this->user->isAdmin()) {
        if (self::API_CONTEXT != $context) {
            $builder
                ->remove('receivers')
                ->remove('images')
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'context' => self::SUPER_ADMIN_CONTEXT,
            'institution' => null,
        ]);
    }
}

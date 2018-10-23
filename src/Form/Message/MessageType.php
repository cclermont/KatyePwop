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
use App\Repository\User\UserRepository;

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
            ->add('videos', CollectionType::class, [
                'allow_add' => true,
                'required' => false,
                'by_reference' => false,
                'entry_type' => VideoType::class,
            ])
        ;

        // if ($this->user->isSuperAdmin() || $this->user->isAdmin()) {
        if (self::API_CONTEXT != $context) {
            $builder
                ->remove('receivers')
                ->remove('images')
                ->remove('videos')
            ;
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
            'context' => self::SUPER_ADMIN_CONTEXT,
        ]);
    }
}

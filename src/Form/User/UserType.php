<?php

namespace App\Form\User;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserType extends AbstractType
{
    private $user;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->user = $tokenStorage->getToken()->getUser();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', EmailType::class)
            ->add('enabled')
            ->add('roles', ChoiceType:: class, [
                'multiple' => true,
                'placeholder' => 'Choisissez un sexe',
                'choices' => $this->getRolesChoices(),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    private function getRolesChoices(): Array
    {
        if ($this->user->isSuperAdmin()) {
           return [
                'Admin' => User::ROLE_ADMIN,
                'Super admin' => User::ROLE_SUPER_ADMIN,
                'Operateur' => User::ROLE_OPERATOR,
                'Agent voirie' => User::ROLE_ROAD_AGENT,
                'Particulier' => User::ROLE_USER,
            ];
        } else if ($this->user->hasRole(User::ROLE_ADMIN)) {
           return [
                'Operateur' => User::ROLE_OPERATOR,
                'Agent voirie' => User::ROLE_ROAD_AGENT,
            ];
        } else {
            return [];
        }
    }
}

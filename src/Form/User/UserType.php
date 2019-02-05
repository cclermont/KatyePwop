<?php

namespace App\Form\User;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserType extends AbstractType
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email', EmailType::class)
            ->add('enabled')
        ;

        if (!$this->security->isGranted(User::ROLE_SUPER_ADMIN) && 
            $this->security->isGranted(User::ROLE_ADMIN)) {
            $builder->add('roles', ChoiceType:: class, [
                'multiple' => true,
                'placeholder' => 'Choisissez un role',
                'choices' => $this->getRolesChoices(),
            ]);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    private function getRolesChoices(): Array
    {
        if ($this->security->isGranted(User::ROLE_SUPER_ADMIN)) {
           return [
                'Super admin' => User::ROLE_SUPER_ADMIN
            ];
        } else if ($this->security->isGranted(User::ROLE_ADMIN)) {
           return [
                'Admin' => User::ROLE_ADMIN,
                'Operateur' => User::ROLE_OPERATOR,
                'Agent voirie' => User::ROLE_ROAD_AGENT,
            ];
        } else {
            return [];
        }
    }
}

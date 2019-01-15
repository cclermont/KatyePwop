<?php

namespace App\Form\FleetManagement;

use App\Entity\FleetManagement\Vehicle;
use App\Entity\FleetManagement\VehicleCategory;
use App\Repository\FleetManagement\VehicleCategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\DependencyInjection\Container;


class VehicleType extends AbstractType
{
    private $vehicleCategoryRepository;
    

    public function __construct( VehicleCategoryRepository $vehicleCategoryRepository )
    {
        $this->vehicleCategoryRepository = $vehicleCategoryRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$entityManager = $container->getDoctrine()->getManager();
        //$vehicleCategoryRepository = new VehicleCategoryRepository($entityManager);
        $builder
            ->add('reg_no')
            ->add('category', ChoiceType::class, [
                'choices'=>$this->vehicleCategoryRepository->findAll(),
                'choice_label' => function($category, $key, $value) {
                    return strtoupper($category->getName());
                },
                'choice_value' => function (VehicleCategory $entity = null) {
                    return $entity ? $entity->getId() : '';
                },
            ])
            ->add('reg_date')
            ->add('cost')
            ->add('make')
            ->add('model')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Vehicle::class,
        ]);
    }
}

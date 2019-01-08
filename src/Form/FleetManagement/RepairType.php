<?php

namespace App\Form\FleetManagement;

use App\Entity\FleetManagement\Repair;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\FleetManagement\VehicleRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RepairType extends AbstractType
{
    private $vehicleRepository;
    

    public function __construct( VehicleRepository $vehicleRepository )
    {
        $this->vehicleRepository = $vehicleRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date')
            ->add('supplier')
            ->add('payment_ref')
            ->add('cost')
            ->add('remarks')
            ->add('vehicle', ChoiceType::class, [
                'choices'=>$this->vehicleRepository->findAll(),
                'choice_label' => function($vehicle, $key, $value) {
                    return strtoupper("{$vehicle->getRegNo()} {$vehicle->getMake()}");
                }/*,
                'choice_value' => function (Vehicle $entity = null) {
                    return $entity ? $entity->getId() : '';
                },*/
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Repair::class,
        ]);
    }
}

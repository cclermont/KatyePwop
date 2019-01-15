<?php

namespace App\Form\FleetManagement;

use App\Entity\FleetManagement\Accident;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\FleetManagement\VehicleRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AccidentType extends AbstractType
{
    private $vehicleRepository;
    

    public function __construct( VehicleRepository $vehicleRepository )
    {
        $this->vehicleRepository = $vehicleRepository;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('details')
            ->add('location')
            ->add('deaths')
            ->add('date')
            ->add('vehicle', ChoiceType::class, [
                'choices'=>$this->vehicleRepository->findAll(),
                'choice_label' => function($vehicle, $key, $value) {
                    return strtoupper("{$vehicle->getRegNo()} {$vehicle->getMake()}");
                }/*,
                'choice_value' => function (Vehicle $entity = null) {
                    return $entity ? $entity->getId() : '';
                },*/
            ])
            ->add('driver_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Accident::class,
        ]);
    }
}

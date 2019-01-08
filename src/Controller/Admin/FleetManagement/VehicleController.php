<?php

namespace App\Controller\Admin\FleetManagement;

use App\Entity\FleetManagement\Vehicle;
use App\Form\FleetManagement\VehicleType;
use App\Repository\FleetManagement\VehicleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FleetManagement\VehicleManager;
use App\Service\Institution\InstitutionManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/vehicle")
 */
class VehicleController extends AbstractController
{
    private $institutionManager;

    public function __construct(
        InstitutionManager $institutionManager
    )
    {
        $this->institutionManager = $institutionManager;
    }
    /**
     * @Route("/", name="admin_fleetmanagement_vehicle_index", methods="GET")
     */
    
    public function index(VehicleRepository $vehicleRepository, Request $request): Response
    {
        $institution = $this->institutionManager->findByUser($this->getUser());
        return $this->render('admin/fleetmanagement/vehicle/index.html.twig', [
            'vehicles' => $vehicleRepository->findBy(['institution_id'=>$institution->getId()]),
        ]);
    }

    /**
     * @Route("/new", name="admin_fleetmanagement_vehicle_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle)
                ->add('saveAndCreateNew', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $institution = $this->institutionManager->findByUser($this->getUser());
            
            $vehicle->setInstitutionId($institution->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicle);
            $em->flush();
            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute("admin_fleetmanagement_vehicle_new");
            }
            return $this->redirectToRoute('admin_fleetmanagement_vehicle_index');
        }

        return $this->render('admin/fleetmanagement/vehicle/new.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_vehicle_show", methods="GET")
     */
    public function show(Vehicle $vehicle): Response
    {
        return $this->render('admin/fleetmanagement/vehicle/show.html.twig', ['entity' => $vehicle]);
    }

    /**
     * @Route("/{id}/edit", name="admin_fleetmanagement_vehicle_edit", methods="GET|POST")
     */
    public function edit(Request $request, Vehicle $vehicle): Response
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_fleetmanagement_vehicle_index', ['id' => $vehicle->getId()]);
        }

        return $this->render('admin/fleetmanagement/vehicle/edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_vehicle_delete", methods="DELETE|POST")
     */
    public function delete(Request $request, Vehicle $vehicle): Response
    {
        /*if ($this->isCsrfTokenValid('delete'.$vehicle->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehicle);
            $em->flush();
        }*/
        $em = $this->getDoctrine()->getManager();
        $em->remove($vehicle);
        $em->flush();
        return $this->redirectToRoute('admin_fleetmanagement_vehicle_index');
    }
}

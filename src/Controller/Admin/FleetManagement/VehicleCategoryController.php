<?php

namespace App\Controller\Admin\FleetManagement;

use App\Entity\FleetManagement\VehicleCategory;
use App\Form\FleetManagement\VehicleCategoryType;
use App\Repository\FleetManagement\VehicleCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\Institution\InstitutionManager;

/**
 * @Route("/vehicle/category")
 */
class VehicleCategoryController extends AbstractController
{
    private $institutionManager;
    public function __construct(
        InstitutionManager $institutionManager
    )
    {
        $this->institutionManager = $institutionManager;
    }
    /**
     * @Route("/", name="admin_fleetmanagement_vehicle_category_index", methods="GET")
     */
    public function index(VehicleCategoryRepository $vehicleCategoryRepository): Response
    {
        $institution = $this->institutionManager->findByUser($this->getUser());
        return $this->render('admin/fleetmanagement/vehicle_category/index.html.twig', 
        ['vehicle_categories' => $vehicleCategoryRepository->findBy(['institution_id'=>$institution->getId()])]);
    }

    /**
     * @Route("/new", name="admin_fleetmanagement_vehicle_category_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $institution = $this->institutionManager->findByUser($this->getUser());
        $vehicleCategory = new VehicleCategory();
        $form = $this->createForm(VehicleCategoryType::class, $vehicleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vehicleCategory->setInstitutionId($institution->getId());
            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicleCategory);
            $em->flush();

            return $this->redirectToRoute('admin_fleetmanagement_vehicle_category_index');
        }

        return $this->render('admin/fleetmanagement/vehicle_category/new.html.twig', [
            'vehicle_category' => $vehicleCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_vehicle_category_show", methods="GET")
     */
    public function show(VehicleCategory $vehicleCategory): Response
    {
        return $this->render('vehicle_category/show.html.twig', ['vehicle_category' => $vehicleCategory]);
    }

    /**
     * @Route("/{id}/edit", name="admin_fleetmanagement_vehicle_category_edit", methods="GET|POST")
     */
    public function edit(Request $request, VehicleCategory $vehicleCategory): Response
    {
        $form = $this->createForm(VehicleCategoryType::class, $vehicleCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_fleetmanagement_vehicle_category_index', ['id' => $vehicleCategory->getId()]);
        }

        return $this->render('admin/fleetmanagement/vehicle_category/edit.html.twig', [
            'vehicle_category' => $vehicleCategory,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_fleetmanagement_vehicle_category_delete", methods="GET|DELETE")
     */
    public function delete(Request $request, VehicleCategory $vehicleCategory): Response
    {
        /*if ($this->isCsrfTokenValid('delete'.$vehicleCategory->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($vehicleCategory);
            $em->flush();
        }*/

        $em = $this->getDoctrine()->getManager();
        $em->remove($vehicleCategory);
        $em->flush();

        return $this->redirectToRoute('admin_fleetmanagement_vehicle_category_index');
    }
}

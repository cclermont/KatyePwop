<?php

namespace App\Controller\Admin\FleetManagement;

use App\Entity\FleetManagement\Maintenance;
use App\Form\FleetManagement\MaintenanceType;
use App\Repository\FleetManagement\MaintenanceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/fleet/management/maintenance")
 */
class MaintenanceController extends AbstractController
{
    /**
     * @Route("/", name="admin_fleetmanagement_maintenance_index", methods="GET")
     */
    public function index(MaintenanceRepository $maintenanceRepository): Response
    {
        return $this->render('admin/fleetmanagement/maintenance/index.html.twig', ['maintenances' => $maintenanceRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_fleetmanagement_maintenance_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $maintenance = new Maintenance();
        $form = $this->createForm(MaintenanceType::class, $maintenance)->add('saveAndCreateNew', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($maintenance);
            $em->flush();

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute("admin_fleetmanagement_maintenance_new");
            }

            return $this->redirectToRoute('admin_fleetmanagement_maintenance_index');
        }

        return $this->render('admin/fleetmanagement/maintenance/new.html.twig', [
            'maintenance' => $maintenance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_maintenance_show", methods="GET")
     */
    public function show(Maintenance $maintenance): Response
    {
        return $this->render('admin/fleetmanagement/maintenance/show.html.twig', ['maintenance' => $maintenance, 'entity'=> $maintenance]);
    }

    /**
     * @Route("/{id}/edit", name="admin_fleetmanagement_maintenance_edit", methods="GET|POST")
     */
    public function edit(Request $request, Maintenance $maintenance): Response
    {
        $form = $this->createForm(MaintenanceType::class, $maintenance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_fleetmanagement_maintenance_edit', ['id' => $maintenance->getId()]);
        }

        return $this->render('admin/fleetmanagement/maintenance/edit.html.twig', [
            'maintenance' => $maintenance,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_maintenance_delete", methods="DELETE")
     */
    public function delete(Request $request, Maintenance $maintenance): Response
    {
        if ($this->isCsrfTokenValid('delete'.$maintenance->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($maintenance);
            $em->flush();
        }

        return $this->redirectToRoute('admin_fleetmanagement_maintenance_index');
    }
}

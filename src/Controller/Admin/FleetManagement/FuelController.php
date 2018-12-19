<?php

namespace App\Controller\Admin\FleetManagement;

use App\Entity\FleetManagement\Fuel;
use App\Form\FleetManagement\FuelType;
use App\Repository\FleetManagement\FuelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fleet/management/fuel")
 */
class FuelController extends AbstractController
{
    /**
     * @Route("/", name="admin_fleetmanagement_fuel_index", methods="GET")
     */
    public function index(FuelRepository $fuelRepository): Response
    {
        return $this->render('admin/fleetmanagement/fuel/index.html.twig', ['fuels' => $fuelRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_fleetmanagement_fuel_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $fuel = new Fuel();
        $form = $this->createForm(FuelType::class, $fuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fuel);
            $em->flush();

            return $this->redirectToRoute('fleet_management_fuel_index');
        }

        return $this->render('admin/fleetmanagement/fuel/new.html.twig', [
            'fuel' => $fuel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_fuel_show", methods="GET")
     */
    public function show(Fuel $fuel): Response
    {
        return $this->render('admin/fleetmanagement/fuel/show.html.twig', ['fuel' => $fuel, 'entity' => $fuel]);
    }

    /**
     * @Route("/{id}/edit", name="admin_fleetmanagement_fuel_edit", methods="GET|POST")
     */
    public function edit(Request $request, Fuel $fuel): Response
    {
        $form = $this->createForm(FuelType::class, $fuel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_fleetmanagement_fuel_show', ['id' => $fuel->getId()]);
        }

        return $this->render('admin/fleetmanagement/fuel/edit.html.twig', [
            'fuel' => $fuel,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_fuel_delete", methods="DELETE|POST")
     */
    public function delete(Request $request, Fuel $fuel): Response
    {
        /*if ($this->isCsrfTokenValid('delete'.$fuel->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fuel);
            $em->flush();
        }*/

        $em = $this->getDoctrine()->getManager();
        $em->remove($fuel);
        $em->flush();

        return $this->redirectToRoute('admin_fleetmanagement_fuel_index');
    }
}

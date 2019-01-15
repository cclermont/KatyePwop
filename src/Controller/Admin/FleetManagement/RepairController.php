<?php

namespace App\Controller\Admin\FleetManagement;

use App\Entity\FleetManagement\Repair;
use App\Form\FleetManagement\RepairType;
use App\Repository\FleetManagement\RepairRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/fleet/management/repair")
 */
class RepairController extends AbstractController
{
    /**
     * @Route("/", name="admin_fleetmanagement_repair_index", methods="GET")
     */
    public function index(RepairRepository $repairRepository): Response
    {
        return $this->render('admin/fleetmanagement/repair/index.html.twig', ['repairs' => $repairRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_fleetmanagement_repair_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $repair = new Repair();
        $form = $this->createForm(RepairType::class, $repair)->add('saveAndCreateNew', SubmitType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($repair);
            $em->flush();

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute("admin_fleetmanagement_repair_new");
            }

            return $this->redirectToRoute('admin_fleetmanagement_repair_index');
        }

        return $this->render('admin/fleetmanagement/repair/new.html.twig', [
            'entity' => $repair,
            'repair' => $repair,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_repair_show", methods="GET")
     */
    public function show(Repair $repair): Response
    {
        return $this->render('admin/fleetmanagement/repair/show.html.twig', ['repair' => $repair, 'entity' => $repair]);
    }

    /**
     * @Route("/{id}/edit", name="admin_fleetmanagement_repair_edit", methods="GET|POST")
     */
    public function edit(Request $request, Repair $repair): Response
    {
        $form = $this->createForm(RepairType::class, $repair);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_fleetmanagement_repair_edit', ['id' => $repair->getId()]);
        }

        return $this->render('admin/fleetmanagement/repair/edit.html.twig', [
            'repair' => $repair,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_repair_delete", methods="DELETE")
     */
    public function delete(Request $request, Repair $repair): Response
    {
        if ($this->isCsrfTokenValid('delete'.$repair->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($repair);
            $em->flush();
        }

        return $this->redirectToRoute('admin_fleetmanagement_repair_index');
    }
}

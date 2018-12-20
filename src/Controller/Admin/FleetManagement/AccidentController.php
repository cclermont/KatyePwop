<?php

namespace App\Controller\Admin\FleetManagement;

use App\Entity\FleetManagement\Accident;
use App\Form\FleetManagement\AccidentType;
use App\Repository\FleetManagement\AccidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/fleet/management/accident")
 */
class AccidentController extends AbstractController
{
    /**
     * @Route("/", name="admin_fleetmanagement_accident_index", methods="GET")
     */
    public function index(AccidentRepository $accidentRepository): Response
    {
        return $this->render('admin/fleetmanagement/accident/index.html.twig', ['accidents' => $accidentRepository->findAll()]);
    }

    /**
     * @Route("/new", name="admin_fleetmanagement_accident_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $accident = new Accident();
        $form = $this->createForm(AccidentType::class, $accident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accident);
            $em->flush();

            return $this->redirectToRoute('admin_fleetmanagement_accident_index');
        }

        return $this->render('admin/fleetmanagement/accident/new.html.twig', [
            'accident' => $accident,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_accident_show", methods="GET")
     */
    public function show(Accident $accident): Response
    {
        return $this->render('admin/fleetmanagement/accident/show.html.twig', ['accident' => $accident,'entity' => $accident]);
    }

    /**
     * @Route("/{id}/edit", name="admin_fleetmanagement_accident_edit", methods="GET|POST")
     */
    public function edit(Request $request, Accident $accident): Response
    {
        $form = $this->createForm(AccidentType::class, $accident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_fleetmanagement_accident_index', ['id' => $accident->getId()]);
        }

        return $this->render('admin/fleetmanagement/accident/edit.html.twig', [
            'accident' => $accident,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_fleetmanagement_accident_delete", methods="POST|DELETE")
     */
    public function delete(Request $request, Accident $accident): Response
    {
        /*if ($this->isCsrfTokenValid('delete'.$accident->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($accident);
            $em->flush();
        }*/
        $em = $this->getDoctrine()->getManager();
        $em->remove($accident);
        $em->flush();

        return $this->redirectToRoute('admin_fleetmanagement_accident_index');
    }
}

<?php

namespace App\Controller\SuperAdmin;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\User\User;

/**
 * UserController 
 *
 * @Route("/user")
 */ 
class UserController extends AbstractController
{
    /**
     * @Route("/", name="super_admin_user", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('super_admin/user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/new", name="super_admin_user_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        return $this->render('super_admin/user/new.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/{id<\d+>}/show", name="super_admin_user_show", methods={"GET"})
     */
    public function show(Request $request, User $user): Response
    {
        return $this->render('super_admin/user/show.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="super_admin_user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user): Response
    {
        return $this->render('super_admin/user/edit.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/{id<\d+>}/delete", name="super_admin_user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        return $this->redirectToRoute("super_admin_user");
    }
}

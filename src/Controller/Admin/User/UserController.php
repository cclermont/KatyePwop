<?php

namespace App\Controller\Admin\User;

use FOS\UserBundle\Mailer\TwigSwiftMailer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\UserBundle\Util\TokenGeneratorInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\User\User;
use App\Service\User\UserManager;
use App\Service\Institution\InstitutionManager;

/**
 * UserController 
 *
 * @Route("/user")
 */ 
class UserController extends AbstractController
{
    /**
    * Entity manager
    */
    private $em;
    private $mailer;
    private $tokenGenerator;
    private $institutionManager;

    public function __construct(UserManager $entityManager, InstitutionManager $institutionManager, TwigSwiftMailer $mailer,
                TokenGeneratorInterface $tokenGenerator)
    {
        $this->mailer = $mailer;
        $this->em = $entityManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->institutionManager = $institutionManager;
    }

    /**
     * @Route("/{page<\d+>?1}/{limit<\d+>?50}", name="admin_user", methods={"GET"})
     */
    public function index(Request $request, $page = 1, $limit = 50): Response
    {
        // Sort and pattern
        $pattern = $request->query->get('pattern', array());
        $sort    = $request->query->get('sort', array('created' => 'DESC'));

        // Get for institution
        $pattern['id'] = $this->institutionManager->getMembersId($this->getUser());
        
        // Get entities
        $entities = $this->em->findAndPaginate($pattern, $sort, $page, $limit);

        // Render view
        return $this->render("{$this->em->getBaseTemplateName('admin')}/user/index.html.twig", [
            'sort' => $sort,
            'page' => $page,
            'limit' => $limit,
            'entities' => $entities,
        ]);
    }

    /**
     * @Route("/new", name="admin_user_new", methods={"GET", "POST"})
     *
     * @IsGranted("ROLE_ADMIN", message="Vous ne pouvez pas ajouter d'utilisateur")
     */
    public function new(Request $request): Response
    {   
        // Create entity
        $entity = $this->em->createEntity();

        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity)
                    ->add('saveAndCreateNew', SubmitType::class);

        // Handle request
        $form->handleRequest($request);

        // Test isSubmitted()
        if ($form->isSubmitted() && $form->isValid()) {

            // Get institution
            $institution = $this->institutionManager->findByUser($this->getUser());

            // Set default password and location
            $entity->setPlainPassword(md5(rand()));

            // Set confirmation token
            if (null === $entity->getConfirmationToken()) {
                $entity->setConfirmationToken($this->tokenGenerator->generateToken());
            }

            // Send password resetting email
            $this->mailer->sendResettingEmailMessage($entity);
            $entity->setPasswordRequestedAt(new \DateTime());
            
            // Create entity
            $this->em->update($entity);
            
            // Add to institution
            $institution->addMember($entity);
            $this->institutionManager->update($institution);

            // Flash messages are used to notify the user about the result
            $this->addFlash('success', 'Element ajouté avec succès');

            if ($form->get('saveAndCreateNew')->isClicked()) {
                return $this->redirectToRoute("{$this->em->getBaseRouteName('admin')}_new");
            }

            return $this->redirectToRoute("{$this->em->getBaseRouteName('admin')}_show", ["id" => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName('admin')}/user/new.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/show", name="admin_user_show", methods={"GET"})
     *
     * @IsGranted("show", subject="entity", message="Vous ne pouvez pas voir cet utilisateur")
     */
    public function show(Request $request, User $entity): Response
    {
        return $this->render("{$this->em->getBaseTemplateName('admin')}/user/show.html.twig", [
            'entity' => $entity,
        ]);
    }

    /**
     * @Route("/{id<\d+>}/edit", name="admin_user_edit", methods={"GET", "POST"})
     *
     * @IsGranted("edit", subject="entity", message="Vous ne pouvez pas editer cet utilisateur")
     */
    public function edit(Request $request, User $entity): Response
    {
        // Create form
        $form = $this->createForm($this->em->getFormType(), $entity);

        // Handle request
        $form->handleRequest($request);

        // Test isSubmitted()
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Create entity
            $this->em->update($entity);

            $this->addFlash('success', 'Element modifié avec succès');

            return $this->redirectToRoute("{$this->em->getBaseRouteName('admin')}_edit", ['id' => $entity->getId()]);
        }

        return $this->render("{$this->em->getBaseTemplateName('admin')}/user/edit.html.twig", [
            'entity' => $entity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id<\d+>}/delete", name="admin_user_delete", methods={"POST"})
     *
     * @IsGranted("delete", subject="entity", message="Vous ne pouvez pas effacer cet utilisateur")
     */
    public function delete(Request $request, User $entity): Response
    {
        // Test if come from delete form
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            $this->addFlash('error', 'Vous ne pouvez pas effacé cet element');
            return $this->redirectToRoute($this->em->getBaseRouteName('admin'));
        }

        // Create entity
        $this->em->delete($entity);

        $this->addFlash('success', 'Element effacé avec succès');

        return $this->redirectToRoute($this->em->getBaseRouteName('admin'));
    }
}

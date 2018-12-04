<?php

namespace App\Controller\Api\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use App\Service\User\UserManager;
use App\Entity\User\Notification;
use App\Controller\Api\ControllerResponseDataTrait;

/**
 * ProfileController 
 *
 * @Route("/user/notification")
 */ 
class NotificationController extends FOSRestController
{
    /**
    * Entity manager
    */
    private $em;

    public function __construct(UserManager $entityManager)
    {
        $this->em = $entityManager;
    }

    // Response data trait
    use ControllerResponseDataTrait;

    /**
     * @Security("has_role('ROLE_USER_SIMPLE')")
     * @Route("/", name="api_user_notification_add", defaults={"_format": "json"}, methods={"POST"})
     */
    public function add(Request $request)
    {
        // Get user profile
        $user = $this->getUser();
        $profile = $user->getProfile();

        $iosToken = $request->request->get("ios_token");
        $androidToken = $request->request->get("android_token");

        if (null != $profile) {

        	$entity = null == $profile->getNotification() ? new Notification() : $profile->getNotification();

        	if (null != $iosToken && count($iosToken) > 2) {
        		$entity->setFirebaseIosToken($androidToken);
        	} else if (null != $androidToken && count($androidToken) > 2) {
        		$entity->setFirebaseAndroidToken($androidToken);
        	}

        	$profile->setNotification($entity);

        	// Set profile to user
            $user->setProfile($profile);

            // Update entity
            $this->em->update($user);

            // Add form to response data
            $resData->set('total', 1);
            $resData->set('data', "done");
            
            // Render view
        	return $this->view($resData, Response::HTTP_NO_CONTENT);
        }

        $resData->set('error', true);

        // Return view
        return $this->view($resData, Response::HTTP_BAD_REQUEST);
    }
}

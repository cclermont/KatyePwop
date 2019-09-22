<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

use App\Entity\User\User;
use App\Entity\Message\Message;
use App\Service\Institution\InstitutionManager;

/**
 * Message Voter
 */
class MessageVoter extends Voter
{
    /**
     * Properties
     */
    private $decisionManager;
    private $institutionManager;

    /**
     * Conts
     */
    private const SHOW = 'show';
    private const EDIT = 'edit';
    private const DELETE = 'delete';


    /**
     * Construct
     */
    public function __construct(InstitutionManager $institutionManager,
                                AccessDecisionManagerInterface $decisionManager){
        
        $this->decisionManager = $decisionManager;
        $this->institutionManager = $institutionManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject): bool
    {
        // this voter is only executed for three specific permissions on Post objects
        return $subject instanceof Message && in_array($attribute, [self::SHOW, self::EDIT, self::DELETE], true);
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $entity, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // the user must be logged in; if not, deny permission
        if (!$user instanceof User || null == $entity->getSender()) {
            return false;
        }

        // Test for super admin
        if ($this->decisionManager->decide($token, [User::ROLE_SUPER_ADMIN, User::ROLE_ADMIN])) {
            return true;
        }

        // Test for admin and operator
        if (in_array($attribute, [self::SHOW, self::EDIT, self::DELETE], true) && 
            ($user == $entity->getSender() || 
             $this->institutionManager->inSameInstitution($user, $entity->getSender())) && 
            ($this->decisionManager->decide($token, [User::ROLE_ADMIN]) ||
             $this->decisionManager->decide($token, [User::ROLE_OPERATOR]))
        ) {
            return true;
        }
        
        return false;
    }
}

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
use App\Entity\Institution\Institution;

/**
 * Institution Voter
 */
class InstitutionVoter extends Voter
{
    /**
     * Properties
     */
    private $decisionManager;

    /**
     * Conts
     */
    private const SHOW = 'show';
    private const EDIT = 'edit';
    private const DELETE = 'delete';


    /**
     * Construct
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager){
        
        $this->decisionManager = $decisionManager;
    }

    /**
     * {@inheritdoc}
     */
    protected function supports($attribute, $subject): bool
    {
        // this voter is only executed for three specific permissions on Post objects
        return $subject instanceof Institution && 
                in_array($attribute, [self::SHOW, self::EDIT, self::DELETE], true);
    }

    /**
     * {@inheritdoc}
     */
    protected function voteOnAttribute($attribute, $entity, TokenInterface $token): bool
    {
        $user = $token->getUser();

        // the user must be logged in; if not, deny permission
        if (!$user instanceof User) {
            return false;
        }

        // Test for super admin
        if ($this->decisionManager->decide($token, [User::ROLE_SUPER_ADMIN])) {
            return true;
        }

        // Test for admin
        if ($entity->getAdmin() == $user && 
            in_array($attribute, [self::SHOW, self::EDIT], true) && 
            $this->decisionManager->decide($token, [User::ROLE_ADMIN])
        ) {
            return true;
        }

        // Test for operator
        if ($entity->getMembers()->contains($user) && 
            in_array($attribute, [self::SHOW], true) && 
            $this->decisionManager->decide($token, [User::ROLE_OPERATOR])
        ) {
            return true;
        }
        
        return false;
    }
}

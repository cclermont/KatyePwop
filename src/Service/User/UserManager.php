<?php

namespace App\Service\User;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use FOS\UserBundle\Model\UserManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Doctrine\UserManager as FOSUserManager;

use App\Entity\User\User;
use App\Form\User\UserType;
use App\Service\Core\AbstractManager;


class UserManager extends AbstractManager
{
    /**
     * Properties
     */
    protected $fosUserManager;
    
    /**
     * Construct
     */
    public function __construct(EntityManagerInterface $em, UserManagerInterface $fosUserManager)
    {
        $this->em = $em;
        $this->fosUserManager = $fosUserManager;
    }
    
    /**
     * Update entity
     */
    public function update($entity){
        
        $this->fosUserManager->updateUser($entity);
    }

    /**
     * Get repository
     */
    public function getRepository(): EntityRepository{
        return $this->em->getRepository(User::class);
    }

    /**
     * Count user by role
     */
    public function countByRole($role) {
        return $this->getRepository()->countByRole($role);
    }

    /**
     * Find user by role
     */
    public function findByRole($role) {
        return $this->getRepository()->findByRole($role);
    }
    
    /**
     * Create entity
     */
    public function createEntity(){
        return $this->fosUserManager->createUser();
    }
    
    /**
     * Get logical name
     */
    public function getFQCN(){
        return User::class;
    }
    
    /**
     * Get form type
     */
    public function getFormType($type = 'default'){
        switch ($type) {
            case 'edit':
            case 'default':
                return UserType::class;
            default:
                return UserType::class;
        }
    }
    
    /**
     * Get base route name
     */
    public function getBaseRouteName($type = 'default'){
        
        switch ($type) {
            case 'api':
                return 'api_user';
            case 'admin':
                return 'admin_user';
            case 'frontend':
                return 'frontend_user';
            case 'default':
            case 'super_admin':
                return 'super_admin_user';
            default:
                return 'super_admin_user';
        }
    }
    
    /**
     * Get base template name
     */
    public function getBaseTemplateName($type = 'default'){
        
        switch ($type) {
            case 'admin':
                return 'admin/user';
            case 'frontend':
                return 'frontend/user';
            case 'default':
            case 'super_admin':
                return 'super_admin/user';
            default:
                return 'super_admin/user';
        }
    }
}

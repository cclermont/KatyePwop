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
    protected $doctrineEM;
    
    /**
     * Construct
     */
    public function __construct(EntityManagerInterface $doctrineEM, UserManagerInterface $em)
    {
        $this->em = $em;
        $this->doctrineEM = $doctrineEM;
    }
    
    /**
     * Update entity
     */
    public function update($entity){
        
        $this->em->updateUser($entity);
    }

    /**
     * Get repository
     */
    public function getRepository(): EntityRepository{
        return $this->doctrineEM->getRepository(User::class);
    }
    
    /**
     * Create entity
     */
    public function createEntity(){
        return new User();
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

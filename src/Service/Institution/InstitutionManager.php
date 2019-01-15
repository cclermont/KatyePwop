<?php

namespace App\Service\Institution;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\User\User;
use App\Entity\Location\Location;
use App\Service\Core\AbstractManager;
use App\Entity\Institution\Institution;
use App\Form\Institution\InstitutionType;


class InstitutionManager extends AbstractManager
{

    /**
     * Get repository
     */
    public function getRepository(): EntityRepository{
        return $this->em->getRepository(Institution::class);
    }
    
    /**
     * In same institution
     */
    public function inSameInstitution(User $user, User $member): bool {
        if ($entity = $this->findByUser($user)) {
            return $entity->hasMember($member);
        }

        return false;
    }
    
    /**
     * Find institution by user
     */
    public function findByUser(User $user): ?Institution {
        return $this->getRepository()->findByUser($user);
    }
    
    /**
     * Find institution by location
     */
    public function findByLocation(Location $location): ?Institution {
        return $this->getRepository()->findByLocation($location);
    }
    
    /**
     * Get members id
     */
    public function getMembersId(User $user): Array {
        
        $ids = array();

        if ($entity = $this->findByUser($user)) {
            foreach ($entity->getMembers() as $item) {
                $ids[] = $item->getId();
            }
        }

        return $ids;
    }
    
    /**
     * Get admins id
     */
    public function getAdminsId(User $user): Array {
        
        $ids = array();

        if ($entity = $this->findByUser($user)) {
            foreach ($entity->getMembers() as $item) {
                if ($item->hasRole(User::ROLE_ADMIN)) {
                    $ids[] = $item->getId();
                }
            }
        }

        return $ids;
    }
    
    /**
     * Create entity
     */
    public function createEntity(){
        return new Institution();
    }
    
    /**
     * Get logical name
     */
    public function getFQCN(){
        return Institution::class;
    }
    
    /**
     * Get form type
     */
    public function getFormType($type = 'default'){
        switch ($type) {
            case 'edit':
            case 'default':
                return InstitutionType::class;
            break;
        }
    }
    
    /**
     * Get base route name
     */
    public function getBaseRouteName($type = 'default'){
        
        switch ($type) {
            case 'api':
                return 'api_institution_institution';
            break;
            case 'admin':
                return 'admin_institution_institution';
            break;
            case 'default':
            case 'super_admin':
                return 'super_admin_institution_institution';
            break;
            case 'frontend':
                return 'frontend_institution_institution';
            break;
        }
    }
    
    /**
     * Get base template name
     */
    public function getBaseTemplateName($type = 'default'){
        
        switch ($type) {
            case 'default':
            case 'super_admin':
                return 'super_admin/institution/';
            break;
            case 'admin':
                return 'admin/institution/';
            break;
            case 'frontend':
                return 'frontend/institution/';
            break;
        }
    }
}

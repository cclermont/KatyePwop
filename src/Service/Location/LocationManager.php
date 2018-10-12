<?php

namespace App\Service\Location;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Location\Location;
use App\Form\Location\LocationType;
use App\Service\Core\AbstractManager;


class LocationManager extends AbstractManager
{

    /**
     * Get repository
     */
    public function getRepository(): EntityRepository{
        return $this->em->getRepository(Location::class);
    }
    
    /**
     * Create entity
     */
    public function createEntity(){
        return new Location();
    }
    
    /**
     * Get logical name
     */
    public function getFQCN(){
        return Location::class;
    }
    
    /**
     * Get form type
     */
    public function getFormType($type = 'default'){
        switch ($type) {
            case 'edit':
            case 'default':
                return LocationType::class;
            default:
                return LocationType::class;
        }
    }
    
    /**
     * Get base route name
     */
    public function getBaseRouteName($type = 'default'){
        
        switch ($type) {
            case 'api':
                return 'api_location';
            case 'admin':
                return 'admin_location';
            case 'frontend':
                return 'frontend_location';
            case 'default':
            case 'super_admin':
                return 'super_admin_location';
            default:
                return 'super_admin_location';
        }
    }
    
    /**
     * Get base template name
     */
    public function getBaseTemplateName($type = 'default'){
        
        switch ($type) {
            case 'admin':
                return 'admin/location';
            case 'frontend':
                return 'frontend/location';
            case 'default':
            case 'super_admin':
                return 'super_admin/location';
            default:
                return 'super_admin/location';
        }
    }
}

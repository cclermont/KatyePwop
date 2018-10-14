<?php

namespace App\Service\Institution;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

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

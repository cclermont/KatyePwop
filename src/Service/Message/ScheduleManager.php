<?php

namespace App\Service\Message;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Message\Schedule;
use App\Entity\Location\Location;
use App\Form\Message\ScheduleType;
use App\Service\Core\AbstractManager;


class ScheduleManager extends AbstractManager
{

    /**
     * Get repository
     */
    public function getRepository(): EntityRepository{
        return $this->em->getRepository(Schedule::class);
    }
    
    /**
     * Find institution by location
     */
    public function findByLocation(Location $location) {
        return $this->getRepository()->findByLocation($location);
    }
    
    /**
     * Create entity
     */
    public function createEntity(){
        return new Schedule();
    }
    
    /**
     * Get logical name
     */
    public function getFQCN(){
        return Schedule::class;
    }
    
    /**
     * Get form type
     */
    public function getFormType($type = 'default'){
        switch ($type) {
            case 'edit':
            case 'default':
                return ScheduleType::class;
            break;
        }
    }
    
    /**
     * Get base route name
     */
    public function getBaseRouteName($type = 'default'){
        
        switch ($type) {
            case 'api':
                return 'api_message_schedule';
            break;
            case 'admin':
                return 'admin_message_schedule';
            break;
            case 'default':
            case 'super_admin':
                return 'super_admin_message_schedule';
            break;
            case 'frontend':
                return 'frontend_message_schedule';
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
                return 'super_admin/message/';
            break;
            case 'admin':
                return 'admin/message/';
            break;
            case 'frontend':
                return 'frontend/message/';
            break;
        }
    }
}

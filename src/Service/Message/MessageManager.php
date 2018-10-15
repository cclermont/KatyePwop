<?php

namespace App\Service\Message;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Message\Message;
use App\Form\Message\MessageType;
use App\Service\Core\AbstractManager;


class MessageManager extends AbstractManager
{

    /**
     * Get repository
     */
    public function getRepository(): EntityRepository{
        return $this->em->getRepository(Message::class);
    }
    
    /**
     * Create entity
     */
    public function createEntity(){
        return new Message();
    }
    
    /**
     * Get logical name
     */
    public function getFQCN(){
        return Message::class;
    }
    
    /**
     * Get form type
     */
    public function getFormType($type = 'default'){
        switch ($type) {
            case 'edit':
            case 'default':
                return MessageType::class;
            break;
        }
    }
    
    /**
     * Get base route name
     */
    public function getBaseRouteName($type = 'default'){
        
        switch ($type) {
            case 'api':
                return 'api_message_message';
            break;
            case 'admin':
                return 'admin_message_message';
            break;
            case 'default':
            case 'super_admin':
                return 'super_admin_message_message';
            break;
            case 'frontend':
                return 'frontend_message_message';
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

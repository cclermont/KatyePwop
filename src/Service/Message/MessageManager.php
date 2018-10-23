<?php

namespace App\Service\Message;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\User\User;
use App\Entity\Message\Message;
use App\Form\Message\MessageType;
use App\Service\Core\AbstractManager;
use App\Entity\Institution\Institution;


class MessageManager extends AbstractManager
{

    /**
     * Get repository
     */
    public function getRepository(): EntityRepository{
        return $this->em->getRepository(Message::class);
    }
    
    /**
     * Count sent by user
     */
    public function countSentByUser(User $sender) {
        return $this->findAndPaginate(['sender' => $sender], [], 1, 10)->getNbResults();
    }
    
    /**
     * Count sent by institution
     */
    public function countSentByInstitution(Institution $sender) {
        return $this->findAndPaginate(['senderInstitution' => $sender], [], 1, 10)->getNbResults();
    }
    
    /**
     * Find received by user
     */
    public function findReceivedByUser(User $user, array $order = array(), $page = null, $limit = null) {
        return $this->getRepository()->findReceivedByUser($user, $order, $page, $limit);
    }
    
    /**
     * Count received by User
     */
    public function countReceivedByUser(User $user) {
        return $this->findReceivedByUser($user)->getNbResults();
    }
    
    /**
     * Find received by institution
     */
    public function findReceivedByInstitution(Institution $receiver, array $order = array(), $page = null, $limit = null) {
        return $this->getRepository()->findReceivedByInstitution($receiver, $order, $page, $limit);
    }
    
    /**
     * Count received by Institution
     */
    public function countReceivedByInstitution(Institution $receiver) {
        return $this->findReceivedByInstitution($receiver)->getNbResults();
    }
    
    /**
     * Received graph
     */
    public function findReceivedGraph(Institution $receiver, array $pattern = array()): array {
        return $this->getRepository()->findReceivedGraph($receiver, $pattern);
    }
    
    /**
     * All graph
     */
    public function findAllGraph(array $pattern = array()): array {
        return $this->getRepository()->allGraph($pattern);
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

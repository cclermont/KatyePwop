<?php

namespace App\Service\Core;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


abstract class AbstractManager
{
    /**
     * Properties
     */
    protected $em;
    
    /**
     * Construct
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    
    /**
     * Create new entity
     */
    public function create($entity){
        
        $this->em->persist($entity);
        
        $this->em->flush();
    }
    
    /**
     * Update entity
     */
    public function update($entity){
        
        $this->em->flush();
    }
    
    /**
     * Delete entity
     */
    public function delete($entity){
        
        $this->em->remove($entity);
        
        $this->em->flush();
    }
    
    /**
     * Find entity
     */
    public function find($id){
        
        return $this->getRepository()->find($id);
    }
    
    /**
     * Find one by
     */
    public function findOneBy(array $pattern){
        
        return $this->getRepository()->findOneBy($pattern);
    }
    
    /**
     * Find all
     */
    public function findAll(): Collection{
        
        return new ArrayCollection($this->getRepository()->findAll());
    }
    
    /**
     * List entities
     */
    public function findBy(array $pattern = array(), array $order = array(), $offset = 0, $limit = 100): Collection{
        
        return new ArrayCollection($this->getRepository()->findBy($pattern, $order, $limit, $offset));
    }
    
    /**
     * Find and paginate
     */
    public function findAndPaginate(array $pattern = array(), array $order = array(), $page = null, $limit = null){
        
        return $this->getRepository()->findAndPaginate($pattern, $order, $page, $limit);
    }
    
    /**
     * Find and paginate with parent
     */
    public function findAndPaginateWithParent($parent, array $pattern = array(), array $order = array(), $page = null, $limit = null){
        
        return $this->getRepository()->findAndPaginateWithParent($parent, $pattern, $order, $page, $limit);
    }
    
    /**
     * Count entities
     */
    public function count(array $pattern = array()){
        
        return $this->getRepository()->count($pattern);
    }
    
    /**
     * Filter entities
     */
    public function filter(array $keyword, $offset = 0, $limit = 100): Collection{
        
        return new ArrayCollection($this->getRepository()->filter($keyword, $offset, $limit));
    }
    
    /**
     * Get repository
     */
    public abstract function getRepository(): EntityRepository;
    
    /**
     * Create entity
     */
    public abstract function createEntity();
    
    /**
     * Get logical name
     */
    public abstract function getFQCN();
    
    /**
     * Get form type
     */
    public abstract function getFormType($type = 'default');
    
    /**
     * Get base route name
     */
    public abstract function getBaseRouteName($type = 'super_admin');
    
    /**
     * Get base template name
     */
    public abstract function getBaseTemplateName($type = 'default');
}

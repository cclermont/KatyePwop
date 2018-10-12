<?php

namespace App\Repository\Core;

use Doctrine\ORM\Query;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Media|null find($id, $lockMode = null, $lockVersion = null)
 * @method Media|null findOneBy(array $criteria, array $orderBy = null)
 * @method Media[]    findAll()
 * @method Media[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * Find and return query
     */
    public function findAndReturnQueryBuilder($parent = null, array $pattern = array(), array $order = array()){
        
        $qb = $this->createQueryBuilder('e');
        
        $qb->where($this->andXPattern($qb, $pattern, $parent));
        
        foreach($order as $key => $value){
            $qb->addOrderBy("e.$key", $value);
        }
        
        return $qb;
    }
    
    /**
     * Filter
     */
    public function filter(array $keyword = array(), $offset = 0, $limit = 500){
        
        $qb = $this->createQueryBuilder('e');
        
        foreach($keyword as $key => $value)
        {
            $qb->where($qb->expr()->like("e.$key", ":$key"))
                ->setParameter("$key", "$value%")
                ->orderBy("e.$key", "ASC")
                ->setFirstResult($offset)
                ->setMaxResults($limit);
            
            break;
        }
        
        return $qb->getQuery()->getResult();
    }
    
    /**
     * Count
     * 
     * @return int
     */
    public function count(array $pattern = array()){
        
        $qb = $this->_em->createQueryBuilder();
        
        $qb->select($qb->expr()->count('e.id'))
            ->from($this->_entityName, 'e')
            ->where($this->andXPattern($qb, $pattern));
        
        return $qb->getQuery()->getSingleScalarResult();
    }

    /**
     * findAndPaginateWithParent
     * 
     * @param string $parent
     * @param <string> $pattern
     * @param <string> $order
     * @param int $page
     * @param int $limit
     *
     * @return Pagerfanta
     */
    public function findAndPaginateWithParent($parent, array $pattern = array(), array $order = array(), $page = 1, $limit = 100)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryAll($parent, $pattern, $order), false));
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        return $paginator;
    }

    /**
     * findAndPaginate
     * 
     * @param <string> $pattern
     * @param <string> $order
     * @param int $page
     * @param int $limit
     *
     * @return Pagerfanta
     */
    public function findAndPaginate(array $pattern = array(), array $order = array(), $page = 1, $limit = 100)
    {
        $paginator = new Pagerfanta(new DoctrineORMAdapter($this->queryAll(null, $pattern, $order), false));
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage($page);

        return $paginator;
    }
    
    /**
     * Query All
     * 
     * @return Query
     */
    protected function queryAll($parent = null, array $pattern = array(), array $order = array())
    {
        $qb = $this->createQueryBuilder('e');
        
        $qb->where($this->andXPattern($qb, $pattern, $parent));
        
        foreach($order as $key => $value){
            $qb->addOrderBy("e.$key", $value);
        }
        
        return $qb->getQuery();
    }
    
    /**
     * Create pattern
     * 
     * @return Expr
     */
    protected function andXPattern($qb, array $pattern = array(), $parent = null)
    {
        $andX = $qb->expr()->andX()->add($qb->expr()->isNotNull('e.id'));
        
        /*
         * If parent not null
        */
        if($parent){
            $andX = $this->addParentToAndXPattern($qb, $andX, $parent);
        }

        // Foreach pattern to add items
        foreach($pattern as $key => $value)
        {
            if(null !== $value)
            {
                if($key == '__like__'){ // Like search
                    foreach($value as $key2 => $value2){                        
                        $andX->add($qb->expr()->like("e.$key2", ":$key2"));
                        $qb->setParameter($key2, "%$value2%");
                    }
                } else if($key == '__not_like__'){ // Like search
                    foreach($value as $key2 => $value2){                        
                        $andX->add($qb->expr()->notLike("e.$key2", ":$key2"));
                        $qb->setParameter($key2, "%$value2%");
                    }
                } else if(is_array($value)){
                    $andX->add($qb->expr()->in("e.$key", $value));
                } else {
                    $andX->add($qb->expr()->eq("e.$key", ":$key"));
                    $qb->setParameter($key, $value);
                }
            }
        }
        
        return $andX;
    }
    
    /**
     * Add parent to andX pattern
     * 
     * @return Expr
     */
    protected abstract function addParentToAndXPattern($qb, $andX, $parent);
}

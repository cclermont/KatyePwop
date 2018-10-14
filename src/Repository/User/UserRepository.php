<?php

namespace App\Repository\User;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\User\User;
use App\Repository\Core\AbstractRepository;
/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends AbstractRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }
    
    /**
     * Find by role
     * 
     * @param string $role
     *
     * @return Pagerfanta
     */
    public function findByRole($role){
        return $this->findAndPaginate(array('__like__' => array('roles' => $role)));
    }
    
    /**
     * Count by role
     * 
     * @return int
     */
    public function countByRole($role){
        return $this->count(array('__like__' => array('roles' => $role)));
    }
    
    /**
     * Add parent to andX pattern
     * 
     * @return Expr
     */
    protected function addParentToAndXPattern($qb, $andX, $parent){
        return $andX;
    }
}

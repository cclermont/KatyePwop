<?php

namespace App\Repository\Message;

use Pagerfanta\Pagerfanta;
use Doctrine\ORM\Query\Expr\Join;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Message\Schedule;
use App\Repository\Core\AbstractRepository;

/**
 * @method Schedule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schedule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schedule[]    findAll()
 * @method Schedule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScheduleRepository extends AbstractRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Schedule::class);
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

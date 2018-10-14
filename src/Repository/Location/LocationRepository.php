<?php

namespace App\Repository\Location;

use Symfony\Bridge\Doctrine\RegistryInterface;

use App\Entity\Location\Location;
use App\Repository\Core\AbstractRepository;
/**
 * @method Location|null find($id, $lockMode = null, $lockVersion = null)
 * @method Location|null findOneBy(array $criteria, array $orderBy = null)
 * @method Location[]    findAll()
 * @method Location[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocationRepository extends AbstractRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Location::class);
    }
    
    /**
     * Add parent to andX pattern
     * 
     * @return Expr
     */
    protected function addParentToAndXPattern($qb, $andX, $parent){
        
        // $qb->innerJoin('e.categories', 'c')
        //     ->addSelect('c');

        // $andX->add($qb->expr()->in('c.id', [$parent]));

        return $andX;
    }
}
